<?php

namespace App\Modules\Profile\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Profile\Requests\UpdateProfileRequest;
use App\Modules\Profile\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        return $this->profileService->updateProfile($user, $request->validated());
    }

    public function deleteProfile(Request $request)
    {
        $user = Auth::user();
        return $this->profileService->deleteProfile($user);
    }
}