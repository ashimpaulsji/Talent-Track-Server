<?php

namespace App\Modules\Employer\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployerService
{
    public function createOrUpdateCompanyProfile($data)
    {
        $user = Auth::user();
        // $employee = $user->employee;

        // error_log(print_r($employee, true));

        error_log(print_r($user, true));

        $employeeData = [
            'position' => $data['position'] ?? 'Employer',
            'department' => $data['department'] ?? 'Management',
            'company_name' => $data['company_name'],
            'company_description' => $data['company_description'],
            'industry' => $data['industry'],
            'website' => $data['website'] ?? null,
            'location' => $data['location'],
            'contact_email' => $data['contact_email'],
            'contact_phone' => $data['contact_phone'],
        ];

        // error_log(print_r($employeeData, true));

        error_log('User ID: ' . $user->id);


        // if (!$employee) {
        //     $employeeData['user_id'] = $user->id;
        //     $employee = Employee::create($employeeData);
        // } else {
        //     $employee->update($employeeData);
        // }

        $employee = Employee::updateOrCreate(
            ['user_id' => $user->id],
            $employeeData
        );

        return $employee;
    }

    public function getCompanyProfile()
    {
        $user = Auth::user();
        return $user->employee;
    }
}
