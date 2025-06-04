<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Services\Auth\AuthApi;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(AuthApi $authApi)
    {
        $this->authApi = $authApi;
    }

    public function register(RegistrationRequest $request)
    {
        try {
            $result = $this->authApi->register($request);

            return response()->json([
                'status_code' => 201,
                'message'     => 'Registration completed successfully',
                'data'        => new UserResource($result)
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
            $result = $this->authApi->login($request);

            return response()->json([
                'status_code' => 200,
                'message'     => 'Login successful',
                'data'        => $result
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

    public function logout(Request $request)
    {
        try {
            $result = $this->authApi->logout($request);

            return response()->json([
                'status_code' => 200,
                'message'     => 'Successfully logged out'
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

    public function getAuthUser()
    {
        return Auth::User();
    }
}
