<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Models\Profile;
use App\Models\Employee;
use App\Models\JobSeeker;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    // Register a new user
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            Profile::create([
                'user_id' => $user->id,
                'address' => $data['address'] ?? null,
                'phone' => $data['phone'] ?? null,
            ]);

            switch ($data['role']) {
                case 'employee':
                    Employee::create([
                        'user_id' => $user->id,
                        'position' => $data['position'] ?? null,
                        'department' => $data['department'] ?? null,
                    ]);
                    break;
                case 'job_seeker':
                    JobSeeker::create([
                        'user_id' => $user->id,
                        'resume' => $data['resume'] ?? null,
                        'skills' => $data['skills'] ?? null,
                        'experience' => $data['experience'] ?? null,
                    ]);
                    break;
                case 'admin':
                    Admin::create([
                        'user_id' => $user->id,
                        'role' => $data['admin_role'] ?? null,
                    ]);
                    break;
            }

            DB::commit();

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Login user and return a token
    public function login(array $credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create token'
            ], 500);
        }

        return $this->createNewToken($token);
    }

    // Logout user (Invalidate the token)
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'status' => 'success',
                'message' => 'User successfully signed out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Refresh the token
    public function refreshToken()
    {
        try {
            return $this->createNewToken(Auth::refresh());
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to refresh token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get the authenticated User
    public function getProfile()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
    
            $profile = $user->profile;
            $roleSpecificProfile = $user->getRoleSpecificProfile();
    
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'profile' => $profile,
                'role_specific_profile' => $roleSpecificProfile
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => Auth::user()
        ]);
    }
}
