<?php

namespace App\Modules\JobSeeker\Services;

use App\Models\JobSeeker;
use App\Models\Job;
use App\Models\AppliedJob;
use App\Models\SavedJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Log;

class JobSeekerService
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function createProfile(array $data)
    {
        $user = Auth::user();

        // console the response in tarminal
         var_dump($user);

        if ($user->jobSeeker) {
            return response()->json(['message' => 'Profile already exists'], 409);
        }

        if (!isset($data['resume']) || !$data['resume'] instanceof \Illuminate\Http\UploadedFile) {
            return response()->json(['message' => 'Resume file is required'], 400);
        }

        $resumeUrl = null;
        $uploadResult = $this->fileUploadService->uploadFile($data['resume'], 'resumes');

        if (!$uploadResult['success']) {
            Log::error('Resume upload failed: ' . ($uploadResult['error'] ?? 'Unknown error'));
            return response()->json(['message' => 'Resume upload failed. Please try again.'], 500);
        }

        $resumeUrl = $uploadResult['url'];

        try {
            $jobSeeker = DB::transaction(function () use ($user, $data, $resumeUrl) {
                return JobSeeker::create([
                    'user_id' => $user->id,
                    'resume' => $resumeUrl,
                    'skills' => $data['skills'],
                    'experience' => $data['experience'],
                ]);
            });

            return response()->json(['message' => 'Profile created successfully', 'data' => $jobSeeker], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create job seeker profile: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create profile. Please try again.'], 500);
        }
    }

    public function updateProfile(array $data)
    {
        $jobSeeker = Auth::user()->jobSeeker;

        if (!$jobSeeker) {
            return response()->json(['message' => 'Job seeker profile not found'], 404);
        }

        if (isset($data['resume']) && $data['resume'] instanceof \Illuminate\Http\UploadedFile) {
            $uploadResult = $this->fileUploadService->uploadFile($data['resume'], 'resumes');

            if (!$uploadResult['success']) {
                return response()->json(['message' => 'Resume upload failed'], 500);
            }
            $data['resume'] = $uploadResult['url'];
        }

        $jobSeeker->update($data);

        return response()->json(['message' => 'Profile updated successfully', 'data' => $jobSeeker], 200);
    }

    public function searchJobs(array $filters)
    {
        $query = Job::query();

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['location'])) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        if (isset($filters['keywords'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('description', 'like', '%' . $filters['keywords'] . '%')
                    ->orWhere('requirements', 'like', '%' . $filters['keywords'] . '%');
            });
        }

        $perPage = $filters['per_page'] ?? 10;
        $jobs = $query->paginate($perPage);

        return response()->json(['data' => $jobs], 200);
    }

    public function saveJob($jobId)
    {
        $jobSeeker = Auth::user()->jobSeeker;
        $job = Job::findOrFail($jobId);

        $existingSavedJob = SavedJob::where('job_seeker_id', $jobSeeker->id)
            ->where('job_id', $job->id)
            ->first();

        if ($existingSavedJob) {
            return response()->json(['message' => 'Job already saved'], 409);
        }

        $savedJob = SavedJob::create([
            'job_seeker_id' => $jobSeeker->id,
            'job_id' => $job->id,
        ]);

        return response()->json([
            'message' => 'Job saved successfully',
            'data' => $savedJob
        ], 201);
    }

    public function getSavedJobs()
    {
        $jobSeeker = Auth::user()->jobSeeker;
        $savedJobs = $jobSeeker->savedJobs()->with('job')->get();

        return response()->json(['data' => $savedJobs], 200);
    }

    public function applyForJob($jobId)
    {
        $jobSeeker = Auth::user()->jobSeeker;

        $appliedJob = AppliedJob::create([
            'job_id' => $jobId,
            'job_seeker_id' => $jobSeeker->id,
            'application_date' => now(),
        ]);

        return response()->json(['message' => 'Application submitted successfully', 'data' => $appliedJob], 201);
    }

    public function getApplicationStatus()
    {
        $jobSeeker = Auth::user()->jobSeeker;
        $applications = $jobSeeker->appliedJobs()->with('job')->get();

        return response()->json(['data' => $applications], 200);
    }
}
