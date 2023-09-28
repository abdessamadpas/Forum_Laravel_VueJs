<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {   
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|',
           
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('AbdessamadPas')->plainTextToken;

        $response = [
            "User" => $user,
            'Token' => $token,
        ];

        return response($response, 201);
    }

    //! Login

    public function login(Request $request)
    {
        $fields = $request->validate([
           
            'email' => 'required|string',
            'password' => 'required|string|',
           
        ]);
        // Check email
        $user = User::where('email', $fields['email'])->first();
        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong credentials'
            ], 401);
        }
        $token = $user->createToken('AbdessamadPas')->plainTextToken;

        $response = [
            "User" => $user,
            'Token' => $token,
        ];

        return response($response, 201);
    }
}
