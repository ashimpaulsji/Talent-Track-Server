<?php

namespace App\Modules\Job\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Job\Requests\CreateJobRequest;
use App\Modules\Job\Requests\UpdateJobRequest;
use App\Modules\Job\Services\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function create(CreateJobRequest $request)
    {
        $job = $this->jobService->createJob($request->validated());
        return response()->json(['message' => 'Job created successfully', 'data' => $job]);
    }

    public function update(UpdateJobRequest $request, $jobId)
    {
        $job = $this->jobService->updateJob($jobId, $request->validated());
        return response()->json(['message' => 'Job updated successfully', 'data' => $job]);
    }

    public function delete($jobId)
    {
        $this->jobService->deleteJob($jobId);
        return response()->json(['message' => 'Job deleted successfully']);
    }

    public function list()
    {
        $jobs = $this->jobService->listJobs();
        return response()->json(['data' => $jobs]);
    }

    public function get($jobId)
    {
        $job = $this->jobService->getJob($jobId);
        return response()->json(['data' => $job]);
    }
}
