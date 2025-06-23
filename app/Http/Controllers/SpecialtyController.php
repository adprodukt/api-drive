<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialities = Speciality::all()->setVisible(['id', 'speciality', "code", "abbreviation"]);

        return response()->json([
            'specialities'=> $specialities
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "speciality" => "required|string",
            "code" => "required|string",
            "abbreviation" => "required|string",

        ]);
        Speciality::create($validated);
        
        return response()->json([
            'data'=> [
                "code" => 201,
                "message" => "Специальность добавлена",
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
    public function update(Request $request, string $speciality_id)
    {   
        $speciality = Speciality::find($speciality_id);
        if(!$speciality) throw new NotFoundHttpException();

        $validated = $request->validate([
            "speciality" => "required|string",
            "code" => "required|string",
            "abbreviation" => "required|string",
        ]);
        $speciality->update($validated);
        return response()->json([
            'data'=> [
                "code" => 200,
                "message" => "Специальность обновлена",
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $speciality_id)
    {
        $speciality = Speciality::find($speciality_id);
        if(!$speciality) throw new NotFoundHttpException();
        
        $speciality->forceDelete();
        return response()->json([
            'data'=> [
                "code" => 200,
                "message" => "Специальность удалена",
            ]
        ], 200);
    }
}
