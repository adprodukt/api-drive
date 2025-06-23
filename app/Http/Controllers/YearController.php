<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $years = Year::all()->setVisible(['id', 'year']);

        return response()->json([
            'years'=> $years
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
            'year' => 'required|integer',
        ]);
        $user = Year::create($validated);
        
        return response()->json([
            'data'=> [
                "code" => 201,
                "message" => "Год добавлен",
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $year_id)
    {
        $year = Year::find($year_id);
        if(!$year) throw new NotFoundHttpException();
        
        $year->forceDelete();
        return response()->json([
            'data'=> [
                "code" => 200,
                "message" => "Год удален",
            ]
        ], 200);
    }
}
