<?php

namespace App\Modules\Employer\Services;

use App\Models\Employee;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class EmployerService
{
    public function createOrUpdateCompanyProfile($data)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            $employee = Employee::create([
                'user_id' => $user->id,
                'position' => 'Employer',
                'department' => 'Management',
            ]);
        }

        $employee->update($data);

        return $employee;
    }

    public function getCompanyProfile()
    {
        $user = Auth::user();
        return $user->employee;
    }

    public function postJob($data)
    {
        $user = Auth::user();
        $employee = $user->employee;

        return $employee->jobs()->create($data);
    }

    public function updateJob($jobId, $data)
    {
        $user = Auth::user();
        $job = $user->employee->jobs()->findOrFail($jobId);
        $job->update($data);

        return $job;
    }

    public function deleteJob($jobId)
    {
        $user = Auth::user();
        $job = $user->employee->jobs()->findOrFail($jobId);
        $job->delete();
    }

    public function getJobs()
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
