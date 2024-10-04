<?php

namespace App\Modules\Employer\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employer\Requests\CompanyProfileRequest;
use App\Modules\Employer\Requests\JobPostRequest;
use App\Modules\Employer\Services\EmployerService;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    protected $employerService;

    public function __construct(EmployerService $employerService)
    {
        $this->employerService = $employerService;
    }

    public function createOrUpdateCompanyProfile(CompanyProfileRequest $request)
    {
        $profile = $this->employerService->createOrUpdateCompanyProfile($request->validated());
        return response()->json(['message' => 'Company profile updated successfully', 'data' => $profile]);
    }

    public function getCompanyProfile()
    {
        $profile = $this->employerService->getCompanyProfile();
        return response()->json(['data' => $profile]);
    }

    public function postJob(JobPostRequest $request)
    {
        $job = $this->employerService->postJob($request->validated());
        return response()->json(['message' => 'Job posted successfully', 'data' => $job]);
    }

    public function updateJob(JobPostRequest $request, $jobId)
    {
        $job = $this->employerService->updateJob($jobId, $request->validated());
        return response()->json(['message' => 'Job updated successfully', 'data' => $job]);
    }

    public function deleteJob($jobId)
    {
        $this->employerService->deleteJob($jobId);
        return response()->json(['message' => 'Job deleted successfully']);
    }

    public function getJobs()
    {
        $jobs = $this->employerService->getJobs();
        return response()->json(['data' => $jobs]);
    }

    public function getJob($jobId)
    {
        $job = $this->employerService->getJob($jobId);
        return response()->json(['data' => $job]);
    }
}
