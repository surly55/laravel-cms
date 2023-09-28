<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Models\Site;
use App\Models\Translation;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * List translations
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $translations = Translation::with('site');

        $search = [];
        $query = Translation::query()->with('site');
        if($request->has('key')) {
            $query->where('key', 'regexp', '/.*' . $request->get('key') . '.*/i');
            $search['key'] = $request->get('key');
        }
        if($request->has('source')) {
            $query->where('source', 'regexp', '/.*' . $request->get('source') . '.*/i');
            $search['source'] = $request->get('source');
        }

        $sortRule = 'key';
        $sortOrder = 'asc';
        if($request->has('sort')) {
            $sortRule = $request->get('sort');
        }
        if($request->has('order')) {
            $sortOrder = $request->get('order');
        }
        $translations = $query->orderBy($sortRule, $sortOrder)->paginate(30);

        $sites = Site::orderBy('name')->where('locales', 'exists', true)->get([ '_id', 'name', 'locales']);

        return view('translation.index', [
            'title' => 'Translations',
            'translations' => $translations,
            'sites' => $sites,
            'search' => $search,
            'sortRule' => $sortRule,
            'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc',
            'bodyClasses' => 'model-index translation-index',
        ]);
    }

    /**
     * Show details for Translation with given ID
     * 
     * @param string $id Translation ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $translation = Translation::findOrFail($id);

        return view('translation.show', [
            'title' => 'View translation: ' . $translation->key,
            'translation' => $translation,
            'bodyClasses' => 'model-show translation-show',
        ]);
    }

    /**
     * Form for creating new translations
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $sites = Site::orderBy('name')->where('locales', 'exists', true)->get([ '_id', 'name', 'locales']);

        return view('translation.create', [
            'title' => 'Create translation',
            'sites' => $sites,
            'bodyClasses' => 'model-create translation-create',
        ]);
    }

    /**
     * Create new Translation and store it
     * 
     * @param \App\Http\Requests\TranslationRequest $request Request
     * @return \Illuminate\Http\RedirectResponse Redirect back to list of translations if successful
     */
    public function store(TranslationRequest $request)
    {
        Translation::create($request->all());

        return redirect()->route('translation.index');
    }

    /**
     * Edit existing translation
     * 
     * @param string $id Translation ID
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $translation = Translation::with('site')->findOrFail($id);
        $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name' ])->keyBy('_id');

        return view('translation.edit', [
            'title' => 'Edit translation: ' . $translation->key,
            'translation' => $translation,
            'sites' => $sites,
            'bodyClasses' => 'model-edit translation-edit',
        ]);
    }

    /**
     * Store updated Translation
     * 
     * @param string $id Translation ID
     * @param \App\Http\Requests\TranslationRequest $request Request
     * @return \Illuminate\Http\RedirectResponse Redirect back to list of translations if successful
     */
    public function update($id, TranslationRequest $request)
    {
        $translation = Translation::findOrFail($id);

        $translation->update($request->all());

        return redirect()->route('translation.index');
    }

    /**
     * Delete Translation with given ID
     * 
     * @param string $id Translation ID
     * @param \Illuminate\Http\Request $request Request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse Returns a JSON response if called through AJAX or a redirect to translations index if called normally
     */
    public function destroy($id, Request $request)
    {
        $response = [
            'success' => true,
            'message' => 'Translation %s successfully deleted'
        ];
        $responseCode = 200;

        try {
            $translation = Translation::find($id);
            $response['message'] = sprintf($response['message'], $translation->key);
            $translation->delete();
        } catch(ModelNotFoundException $e) {
            $response['success'] = false;
            $response['message'] = 'Translation with ID ' . $id . ' not found!';
            $responseCode = 404;
        } catch(\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Failed to delete translation.';
            $responseCode = 500;
        }

        if($request->ajax()) {
            return response()->json($response, $responseCode);
        }

        return redirect()->route('translation.index');
    }
}