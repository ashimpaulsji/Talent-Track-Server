<?php

namespace App\Modules\Job\Services;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobService
{
    public function createJob($data)
    {
        $user = Auth::user();
        $data['employer_id'] = $user->employee->id;
        $data['is_recent'] = true;
        $data['posted_time'] = now()->diffForHumans();

        return Job::create($data);
    }

    public function updateJob($jobId, $data)
    {
        $user = Auth::user();
        $job = $user->employee->jobs()->findOrFail($jobId);

        $data['is_recent'] = $job->created_at->gt(now()->subDays(7));
        $data['posted_time'] = $job->created_at->diffForHumans();

        $job->update($data);

        return $job;
    }

    public function deleteJob($jobId)
    {
        $user = Auth::user();
        $job = $user->employee->jobs()->findOrFail($jobId);
        $job->delete();
    }

    public function listJobs()
    {
        $user = Auth::user();
        return $user->employee->jobs;
    }

    public function getJob($jobId)
    {
        $user = Auth::user();
        return $user->employee->jobs()->findOrFail($jobId);
    }
}
