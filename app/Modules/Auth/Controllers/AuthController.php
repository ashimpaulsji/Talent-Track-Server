<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Requests\ForgotPasswordRequest;
use App\Modules\Auth\Requests\ResetPasswordRequest;
use App\Modules\Auth\Services\AuthService;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return ApiResponse::success([
            'user' => $result['user'],
            'authorization' => [
                'token' => $result['token'],
                'type' => 'bearer',
            ]
        ], 'User created successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $result = $this->authService->login($credentials);

            if ($result['success']) {
                return ApiResponse::success([
                    'user' => $result['user'],
                    'authorization' => [
                        'token' => $result['token'],
                        'type' => 'bearer',
                    ]
                ], 'User logged in successfully');
            } else {
                return ApiResponse::error($result['message'], 401);
            }
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred during login: ' . $e->getMessage(), 500);
        }
    }

    public function refresh()
    {
        return ApiResponse::success($this->authService->refresh(), 'Token refreshed successfully');
    }

    public function logout()
    {
        $this->authService->logout();
        return ApiResponse::success(null, 'User successfully signed out');
    }

    public function profile()
    {
        return ApiResponse::success(Auth::user(), 'User profile retrieved successfully');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $result = $this->authService->forgotPassword($request->validated());
        if ($result) {
            return ApiResponse::success(null, 'Reset password link sent to your email');
        }
        return ApiResponse::error('Unable to send reset link');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->authService->resetPassword($request->validated());
        if ($result) {
            return ApiResponse::success(null, 'Password has been successfully reset');
        }
        return ApiResponse::error('Unable to reset password');
    }
}
