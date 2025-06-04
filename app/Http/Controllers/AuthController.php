<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request) 
    {
        try {
            $newUser = User::create([
                'name'             => $request->name,
                'email'            => $request->email,
                'password'         => Hash::make($request->password)
            ]);

            return response()->json([
                'status_code' => 201,
                'message'     => 'Successful',
                'data'        => new UserResource($newUser)
            ]);
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status_code' => 400,
                    'message'     => $e->getMessage(),
                ],
                400
            );
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
            ];

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid login credentials'
                ], 401);
            }

            $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
                'grant_type'    => 'password',
                'client_id'     => env('PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                'username'      => $request->email,
                'password'      => $request->password,
                'scope'         => '',
            ]);

            $authResponse = $response->json();
            $user         = Auth::user();

            return response()->json([
                'message'       => 'Login successful',
                'expires_in'    => $authResponse['expires_in'],
                'access_token'  => $authResponse['access_token'],
                'refresh_token' => $authResponse['refresh_token']
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status_code' => 400,
                'message'     => $e->getMessage(),
            ], 400);
        }
    }

    public function getAuthUser()
    {
        return Auth::User();
    }
}
