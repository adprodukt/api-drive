<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Speciality;
use App\Models\Year;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        $groups = $groups->fresh('year', 'speciality');
        
        if(count($groups) === 0) return response()->json([
                'groups'=> []
            ], 200);

        foreach ($groups as $value) {
            $result[] = [
                'id' => $value->id,
                'group' => $value->group,
                'speciality' => $value->speciality->speciality,
                'year' => $value->year->year,
            ];
        }

        return response()->json([
            'groups'=> $result
        ], 200);
    }

    public function index_year(string $year_id)
    {
        $year = Year::find($year_id);
        if(!$year) throw new NotFoundHttpException();

        $groups = $year->groups;
        if(count($groups) === 0) return response()->json([
                'groups'=> []
            ], 200);

        $groups = $groups->fresh('year', 'speciality');
        
        foreach ($groups as $value) {
            $result[] = [
                'id' => $value->id,
                'group' => $value->group,
                'speciality' => $value->speciality->speciality,
                'year' => $value->year->year,
            ];
        }

        return response()->json([
            'groups'=> $result
        ], 200);
    }
    
    public function index_speciality(string $speciality_id)
    {
        $speciality = Speciality::find($speciality_id);
        if(!$speciality) throw new NotFoundHttpException();

        $groups = $speciality->groups;
        if(count($groups) === 0) return response()->json([
            'groups'=> []
        ], 200);

        $groups = $groups->fresh('year', 'speciality');
        
        foreach ($groups as $value) {
            $result[] = [
                'id' => $value->id,
                'group' => $value->group,
                'speciality' => $value->speciality->speciality,
                'year' => $value->year->year,
            ];
        }

        return response()->json([
            'groups'=> $result
        ], 200);
    }
    
    public function index_files(string $group_id)
    {   
        $group = Group::find($group_id);
        if(!$group) throw new NotFoundHttpException();

        $files = $group->files->setVisible(['id', 'file_name', 'student', 'topic']);

        if(count($files) === 0) return response()->json([
                'files'=> []
            ], 200);

        return response()->json([
            'files'=> $files
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
            "year_id" => "required|integer|exists:App\Models\Year,id",
            "speciality_id" => "required|integer|exists:App\Models\Speciality,id",
            "group" => "required|string",

        ]);
        Group::create($validated);
        
        return response()->json([
            'data'=> [
                "code" => 201,
                "message" => "Группа добавлена",
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
    public function update(Request $request, string $group_id)
    {
        $group = Group::find($group_id);
        if(!$group) throw new NotFoundHttpException();

        $validated = $request->validate([
            "year_id" => "required|integer|exists:App\Models\Year,id",
            "speciality_id" => "required|integer|exists:App\Models\Speciality,id",
            "group" => "required|string",
        ]);
        $group->update($validated);
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
    public function destroy(string $group_id)
    {
        $group = Group::find($group_id);
        if(!$group) throw new NotFoundHttpException();
        
        // $group->forceDelete();
        return response()->json([
            'data'=> [
                "code" => 200,
                "message" => "Группа удален",
            ]
        ], 200);
    }
}
