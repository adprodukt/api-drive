<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File as RulesFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function download(string $file_id)
    {
        $file = File::find($file_id);
        if(!$file) throw new NotFoundHttpException();

        
        return Storage::download($file->file_name);
    }

    public function search(Request $request)
    {
        $files = File::where('topic', 'LIKE', "%{$request->query('query')}%")
            ->orWhere('student', 'LIKE', "%{$request->query('query')}%")->get();
        
        return response()->json([
            'files'=>  $files,
        ], 200); 
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "student" => "required|string",
            "topic" => "required|string",
            "file" => ["required", 'file',
                RulesFile::types(['zip', 'rar', '7zip', '7z']),
            ],
            "group_id" => "required|integer|exists:App\Models\Group,id"

        ]);

        $file = $request->file('file');
        if(!$file->isValid()) return response()->json([
                'error' => [
                    'code' => 400,
                    "messege" => "Файл не загрузился",
                ]
            ], 400);

        
        
        $path = $file->storeAs('files', uniqid().'.'.$file->getClientOriginalExtension(), 'local');
        $validated['file_name'] = $path;
        unset($validated['file']);
        

        File::create($validated);
        return response()->json([
            'data'=> [
                "code" => 201,
                "message" => "ВКР загружена",
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $file_id)
    {

        $file = File::find($file_id);
        if(!$file) throw new NotFoundHttpException();

        if (!$request->hasFile('file')) {
            $validated = $request->validate([
                "student" => "required|string",
                "topic" => "required|string",
                "group_id" => "required|integer|exists:App\Models\Group,id"
            ]);

            $file->update($validated);
            return response()->json([
                'data'=> [
                    "code" => 200,
                    "message" => "ВКР обновлена",
                ]
            ], 200);
        }

        $validated = $request->validate([
            "student" => "required|string",
            "topic" => "required|string",
            "file" => ["required", 'file',
                RulesFile::types(['zip', 'rar', '7zip', '7z']),
            ],
            "group_id" => "required|integer|exists:App\Models\Group,id"
        ]);

        $new_file = $request->file('file');

        if(!$new_file->isValid()) return response()->json([
                'error' => [
                    'code' => 400,
                    "messege" => "Файл не загрузился",
                ]
            ], 400);

        
        Storage::delete($file->file_name);

        $path = $new_file->storeAs(
            '', 
            explode('.', $file->file_name)[0].'.'.$new_file->getClientOriginalExtension(), 
            'local'
        );

        $validated['file_name'] = $path;
        unset($validated['file']);
        
        $file->update($validated);
        return response()->json([
            'data'=> [
                "code" => 200,
                "message" => "ВКР обновлена",
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $file_id)
    {
        $file = File::find($file_id);
        if(!$file) throw new NotFoundHttpException();

        Storage::delete($file->file_name);
        $file->delete();

        return response()->json([
            'data'=> [
                "code" => 200,
                "message" => "ВКР удалена",
            ]
        ], 200);
    }
}
