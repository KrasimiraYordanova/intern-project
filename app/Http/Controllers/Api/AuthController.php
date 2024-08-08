<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        return $this->attemptLogin($validatedData['email'], $validatedData['password']);
    }

    public function attemptLogin($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.']);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json(['access_token' => $token]);
    }


    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json(['access_token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(["logged out successfully"]);
    }
}
