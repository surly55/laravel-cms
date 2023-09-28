<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Models\Media;
use App\Models\Storage;

use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Image;
use League\Flysystem\Filesystem;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Sftp\SftpAdapter;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $searchCriteria = [];

        $itemsPerPage = 12;
        $skip = 0;
        if($request->ajax()) {
            $itemsPerPage = 6;
        }

        $mediaQuery = Media::query();
        if($request->has('category') && $request->get('category') != '-1') {
            $mediaQuery->where('category', $request->get('category'));
            $searchCriteria['category'] = $request->get('category');
        }
        if($request->has('caption')) {
            $mediaQuery->where('caption', 'regexp', '/.*' . $request->get('caption') . '.*/i');
            $searchCriteria['caption'] = $request->get('caption');
        }
        if($request->has('skip')) {
            $skip = (int)$request->get('skip');
        }
        $mediaQuery = $mediaQuery->orderBy('updated_at', 'desc');
        $mediaCount = $mediaQuery->count();
        $media = $mediaQuery->skip($skip)->take($itemsPerPage)->get();

        $categories = Media::distinct()->get([ 'category' ]);
        $categoriesArray = [];
        foreach ($categories as $cat) {
            $categoriesArray[] = $cat[0];
        }
        sort($categoriesArray);

        if($request->ajax()) {
            return response()->json([ 
                'media' => $media->toArray(),
                'total' => $mediaCount,
                'categories' => $categoriesArray,
            ]);
        }
        
        return view('media.index', [
            'media' => $media,
            'categories' => $categoriesArray,
            'searchCriteria' => $searchCriteria,
        ]);
    }

    public function upload()
    {
        $storages = Storage::lists('name', '_id')->toArray(); 
        $categories = Media::distinct()->get([ 'category' ]);
        $categoriesArray = [];
        foreach ($categories as $cat) {
            $categoriesArray[] = $cat[0];
        }
        sort($categoriesArray);

        return view('media.upload', [
            'title' => 'Upload media',
            'storages' => $storages,
            'categories' => $categoriesArray,
        ]);
    }

    public function store(MediaRequest $request)
    {
        $file = $request->file('upload_file');
        $fileName = $this->sanitizeFilename(substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.')-strlen($file->getClientOriginalName())));
        $fileExtension = $file->guessExtension();
        $fileNameFull = $fileName . '.' . $fileExtension;

        $storage = Storage::findOrFail($request->storage_id);
        $adapter = $this->getStorageAdapter($storage->type, $storage->options);

        $fs = new Filesystem($adapter);
        try {
            $up = $fs->put($fileNameFull, File::get($file));
            if($up === false) {
                $request->session()->flash('error', 'Failed to upload file.');
                return redirect()->back();
            }
        } catch(\Exception $e) {
            $request->session()->flash('error', 'Failed to upload file.');
            return redirect()->back();
        }

        $metadata = [
            'mimetype' => $file->getMimeType(),
        ];
        if(in_array($metadata['mimetype'], [ 'image/gif', 'image/jpeg', 'image/png' ])) {
            $image = Image::make($file);
            $metadata['height'] = $image->height();
            $metadata['width'] = $image->width();
        }

        $media = new Media([
            'caption' => $request->caption,
            'category' => (!$request->has('category') || $request->get('category') == '0') ? null : $request->get('category'),
            'filename' => $fileNameFull,
            'storage_id' => $request->storage_id,
            'metadata' => $metadata,
        ]);
        $media->save();

        // Generate thumbnail
        if(in_array($metadata['mimetype'], [ 'image/gif', 'image/jpeg', 'image/png' ])) {
            $image->heighten(200)->save('uploads/thumbnails/' . $media->_id);
        }

        return redirect()->route('media.index');
    }

    public function edit($id)
    {
        $media = Media::findOrFail($id);
        $categories = Media::distinct()->get([ 'category' ]);
        $categoriesArray = [];
        foreach ($categories as $cat) {
            $categoriesArray[] = $cat[0];
        }
        sort($categoriesArray);

        return view('media.edit', [
            'title' => 'Edit media: ' . $media->caption,
            'media' => $media,
            'categories' => $categoriesArray,
        ]);
    }

    public function update($id, MediaRequest $request) 
    {
        $media = Media::findOrFail($id);
        $media->update($request->all());

        return redirect()->route('media.index');
    }

    public function destroy($id, Request $request)
    {
        $response = [
            'success' => true,
            'message' => 'Media successfully deleted.',
        ];
        $responseCode = 200;
        
        try {
            $file = Media::with('storage')->findOrFail($id);

            $adapter = $this->getStorageAdapter($file->storage->type, $file->storage->options);
            $fs = new Filesystem($adapter);
            try {
                $fs->delete($file->filename);
            } finally {
                $file->delete();
            }
        } catch(ModelNotFoundException $e) {
            $response = [
                'success' => false,
                'message' => 'Media with given ID doesn\'t exist.',
            ];
            $responseCode = 404;
        } catch(FileNotFoundException $e) {
            // Do nothing...
        } catch(\Exception $e) {
            dd($e);
            $response = [
                'success' => false,
                'message' => 'Failed to delete media.',
            ];
            $responseCode = 500;
        } finally {
            if($request->ajax()) {
                return response()->json($response, $responseCode);
            }
            return redirect()->route('page.index');
        }

        return redirect()->route('page.index');
    }

    private function getStorageAdapter($type, $options)
    {
        switch($type) {
            case 'sftp':
                $adapter = new SftpAdapter([
                    'host' => $options['host'],
                    'port' => $options['port'],
                    'username' => $options['username'],
                    'password' => $options['password'],
                ]);
                break;
            default:
                throw new \Exception('Unknown storage type ' . $type);
        }

        return $adapter;
    }

    /**
     * Sanitize a filename by striping away all characters except a-z, A-Z, 0-9, - and _
     * Replaces spaces by _
     * 
     * @param string $filename Filename to sanitize
     * @return string Sanitized filename
     */
    private function sanitizeFilename($filename)
    {
        return preg_replace('/[^\w-]/i', '', preg_replace('/\s+/', '_', $filename));
    }

}