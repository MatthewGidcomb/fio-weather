<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\User;

class AuthController extends Controller
{
    /**
     * Create a new user instance in response to a registration request
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:users',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response($user, 201);
    }

    /**
     * Attempt to log a user in
     */
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        $token = JWTAuth::attempt($credentials);

        if ($token) {
            return response([
                'status' => 'success'
            ])->header('Authorization', $token);
        } else {
            return response([], 400);
        }
    }

    /**
     * Log the current user out of the application
     */
    public function logout()
    {
        JWTAuth::invalidate();
        return response([], 200);
    }

    /**
     * Used by vue-auth
     */
    public function refresh(Request $request)
    {
        return response([
            'status' => 'success'
        ]);
    }

    /**
     * return information about the currently logged-in user
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }
}
