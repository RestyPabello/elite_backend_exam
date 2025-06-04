<?php

namespace App\Services\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthApi 
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register($request)
    {
        $newUser = $this->user->create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $newUser;
    }

    public function login($request) 
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $user = $this->user->where('username', $request->username)->first();

        if (!$user || !Auth::attempt($credentials)) {
            throw new Exception('Invalid username or password.');
        }
        
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type'    => 'password',
            'client_id'     => config('passport.password_client_id'),
            'client_secret' => config('passport.password_client_secret'),
            'username'      => $user->email,
            'password'      => $request->password,
            'scope'         => '',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to retrieve access token.');
        }

        $user         = Auth::user();
        $authResponse = $response->json();

        return [
            'expires_in'    => $authResponse['expires_in'],
            'access_token'  => $authResponse['access_token'],
            'refresh_token' => $authResponse['refresh_token']
        ];
    }

    public function logout($request)
    {
        return $request->user()->token()->revoke();
    }
}