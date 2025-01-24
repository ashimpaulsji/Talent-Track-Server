<?php
namespace App\Modules\Employer\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\Employer\Requests\CompanyProfileRequest;
use App\Modules\Employer\Services\EmployerService;


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
}
