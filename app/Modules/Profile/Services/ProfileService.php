<?php

namespace App\Modules\Profile\Services;

use App\Models\User;
use App\Models\Profile;
use App\Models\Employee;
use App\Models\JobSeeker;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function updateProfile(User $user, array $data)
    {
        DB::beginTransaction();

        try {
            $user->update([
                'photo' => $data['photo'] ?? $user->photo,
            ]);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                ]
            );

            switch ($user->role) {
                case 'employee':
                    $user->employee()->updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'position' => $data['position'],
                            'department' => $data['department'],
                        ]
                    );
                    break;
                case 'job_seeker':
                    $user->jobSeeker()->updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'resume' => $data['resume'],
                            'skills' => $data['skills'],
                            'experience' => $data['experience'],
                        ]
                    );
                    break;
                case 'admin':
                    $user->admin()->updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'role' => $data['admin_role'],
                        ]
                    );
                    break;
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'user' => $user->fresh()->load(['profile', 'employee', 'jobSeeker', 'admin']),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteProfile(User $user)
    {
        DB::beginTransaction();

        try {
            // Delete role-specific data
            switch ($user->role) {
                case 'employee':
                    $user->employee()->delete();
                    break;
                case 'job_seeker':
                    $user->jobSeeker()->delete();
                    break;
                case 'admin':
                    $user->admin()->delete();
                    break;
            }

            // Delete profile
            $user->profile()->delete();

            // Delete user
            $user->delete();

            DB::commit();

            // Logout the user
            Auth::logout();

            return response()->json([
                'status' => 'success',
                'message' => 'User profile and all associated data have been deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete user profile',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}