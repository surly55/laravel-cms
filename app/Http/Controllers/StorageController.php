<?php

namespace App\Http\Controllers;

use App\Models\Storage;

use Illuminate\Http\Request;

class StorageController extends Controller 
{
    public function index()
    {
        $storages = Storage::paginate(10);

        return view('storage.index', [
            'storages' => $storages
        ]);
    }

    public function create()
    {
        return view('storage.create', [
            'storageTypes' => [
                'sftp' => 'SFTP',
            ],
        ]);
    }

    public function store(Request $request)
    {
        Storage::create($request->all());
        
        return redirect()->route('storage.index');
    }
}