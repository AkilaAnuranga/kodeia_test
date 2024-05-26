<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        //validate data
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        // create user
        $user = User::create($data);

        // generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // response with token
        return response()->json([
            'token' => $token
        ],200);
    }
}
