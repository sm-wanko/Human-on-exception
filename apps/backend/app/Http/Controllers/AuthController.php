<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use App\Services\Auth\DuplicateEmailException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** 登録・ログイン・表示名 */
final class AuthController
{
    public function __construct(private readonly AuthService $auth)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->auth->register(
                email: $request->string('email')->toString(),
                password: $request->string('password')->toString(),
                displayName: $request->string('display_name')->toString(),
            );
        } catch (DuplicateEmailException) {
            return response()->json(['message' => 'Email is already registered'], 422);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json(['display_name' => $user->display_name], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->auth->attempt(
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );
        if ($user === null) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json(['display_name' => $user->display_name]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(null, 204);
    }

    public function session(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user === null) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return response()->json(['display_name' => $user->display_name]);
    }
}
