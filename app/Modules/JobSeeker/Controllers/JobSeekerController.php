<?php

namespace App\Modules\JobSeeker\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobSeeker\Requests\CreateProfileRequest;
use App\Modules\JobSeeker\Requests\UpdateProfileRequest;
use App\Modules\JobSeeker\Requests\SearchJobRequest;
use App\Modules\JobSeeker\Services\JobSeekerService;
use Illuminate\Support\Facades\Log;

class JobSeekerController extends Controller
{
    protected $jobSeekerService;

    public function __construct(JobSeekerService $jobSeekerService)
    {
        $this->jobSeekerService = $jobSeekerService;
    }

    public function createProfile(CreateProfileRequest $request)
    {
        try {
            $result = $this->jobSeekerService->createProfile($request->validated());
            return response()->json($result, $result['status'] ?? 200);
        } catch (\Exception $e) {
            Log::error('Create profile error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the profile'], 500);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $result = $this->jobSeekerService->updateProfile($request->validated());
            return response()->json($result, $result['status'] ?? 200);
        } catch (\Exception $e) {
            Log::error('Update profile error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the profile'], 500);
        }
    }

    public function searchJobs(SearchJobRequest $request)
    {
        try {
            $result = $this->jobSeekerService->searchJobs($request->validated());
            return response()->json($result, $result['status'] ?? 200);
        } catch (\Exception $e) {
            Log::error('Search jobs error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while searching for jobs'], 500);
        }
    }

    public function saveJob($jobId)
    {
        try {
            $result = $this->jobSeekerService->saveJob($jobId);
            return response()->json($result, $result['status'] ?? 200);
        } catch (\Exception $e) {
            Log::error('Save job error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while saving the job'], 500);
        }
    }

    public function getSavedJobs()
    {
        try {
            $result = $this->jobSeekerService->getSavedJobs();
            return response()->json($result, $result['status'] ?? 200);
        } catch (\Exception $e) {
            Log::error('Get saved jobs error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while retrieving saved jobs'], 500);
        }
    }

    public function applyForJob($jobId)
    {
        try {
            $result = $this->jobSeekerService->applyForJob($jobId);
            return response()->json($result, $result['status'] ?? 200);
        } catch (\Exception $e) {
            Log::error('Apply for job error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while applying for the job'], 500);
        }
    }

    public function getApplicationStatus()
    {
        try {
            $result = $this->jobSeekerService->getApplicationStatus();
            return response()->json($result, $result['status'] ?? 200);
        } catch (\Exception $e) {
            Log::error('Get application status error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while retrieving application status'], 500);
        }
    }
}
