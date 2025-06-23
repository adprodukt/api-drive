<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function authorization(Request $request)
    {
        $validate = $request->all();
        $user = User::where(['email'=>$validate['email']])->first();
        if(! $user || ! Hash::check($validate['password'], $user->password))
            return response()->json([
                "message"=> "Login failed"
            ], 403);

        $token = $user->createToken($user['email'])->plainTextToken;
        return response()->json([
            "data" => [
                "user"=> [
                    "id" => $user['id'],
                    "name" => "{$user['first_name']} {$user['last_name']} {$user['patronymic']}",
                    "birth_date" => $user['birth_date'],
                    "email" => $user['first_name'],
                    "role" => Role::find($user['role_id'])['role'],
                ],
                "token" => $token
            ]
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'first_name' => 'required|string|regex:/^[A-Z].*/', 
            'last_name' => 'required|string|regex:/^[A-Z].*/', 
            'patronymic' => 'required|string|regex:/^[A-Z].*/', 
            'email' => 'required|string|email|unique:users,email', 
            'password' => 'required|string|min:3|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/', 
            'birth_date' => 'required|string|date', 
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        
        return response()->json([
            'data'=> [
                'data'=> [
                    'name' => "{$user['first_name']} {$user['last_name']} {$user['patronymic']}",
                    "email" => $user['first_name'],
                    "role" => User::find($user['id'])->role->role,
                ],
                "code" => 201,
                "message" => "Пользователь создан",
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
    public function destroy(string $id)
    {
        //
    }
}
