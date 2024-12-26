<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\UpdateUserRequest;
use App\Modules\User\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAllUsers()
    {
        return $this->userService->getAllUsers();
    }

    public function getUser($id)
    {
        return $this->userService->getUser($id);
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        return $this->userService->updateUser($request->validated(), $id);
    }

    public function deleteUser($id)
    {
        return $this->userService->deleteUser($id);
    }
}