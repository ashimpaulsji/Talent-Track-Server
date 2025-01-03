<?php

namespace App\Modules\Auth\Services;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\JobSeeker;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'country' => $data['country'],
            'job_title' => $data['job_title'] ?? null,
            'newsletter' => $data['newsletter'],
            'terms' => $data['terms'],
            'role' => $data['role'],
        ]);

        if ($user->id) {
            Profile::create(['user_id' => $user->id]);
        }

        switch ($user->role) {
            case 'employee':
                Employee::create(['user_id' => $user->id]);
                break;
            case 'job_seeker':
                JobSeeker::create(['user_id' => $user->id]);
                break;
            case 'admin':
                Admin::create(['user_id' => $user->id]);
                break;
        }

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $credentials)
    {
        try {
            $user = User::where('email', $credentials['email'])->first();
            if (!$user) {
                return ['success' => false, 'message' => 'Invalid credentials'];
            }
            if ($credentials['password'] === $user->password) {
                $token = JWTAuth::fromUser($user);

                return [
                    'success' => true,
                    'user' => $user,
                    'token' => $token
                ];
            } else {
                return ['success' => false, 'message' => 'Invalid credentials'];
            }
        } catch (JWTException $e) {
            return ['success' => false, 'message' => 'Failed to create token'];
        }
    }


    public function refresh()
    {
        return $this->createNewToken(JWTAuth::parseToken()->refresh());
    }

    public function logout()
    {
        Auth::logout();
        return true;
    }

    public function forgotPassword(array $data)
    {
        $status = Password::sendResetLink($data);
        return $status === Password::RESET_LINK_SENT;
    }

    public function resetPassword(array $data)
    {
        $status = Password::reset($data, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        });

        return $status === Password::PASSWORD_RESET;
    }

    protected function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => Auth::user()
        ];
    }
}
