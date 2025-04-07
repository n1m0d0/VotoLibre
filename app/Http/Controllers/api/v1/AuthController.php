<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'is_success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Access')->accessToken;

        return response()->json([
            'is_success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => new UserResource($user),
                'token' => [
                    'type' => 'Bearer',
                    'access_token' => $token,
                ],
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens->each(function ($token) {
            $token->revoke();
        });

        return response()->json([
            'is_success' => true,
            'message' => 'Logout successful',
        ]);
    }
}
