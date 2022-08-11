<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    // Logout
    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('myAppToken')->plainTextToken;
        if (isset($user) && Hash::check($request->password, $user->password)) {
            return Response::json([
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return Response::json([
            'message' => 'Credential Do Not Match...',
        ], 200);

    }

    // Logout
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return Response::json([
            'message' => 'Logout Success',
        ], 200);
    }

    // Register
    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('myAppToken')->plainTextToken;

        return Response::json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}
