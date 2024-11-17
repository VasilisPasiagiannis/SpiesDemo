<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Domains\Auth\Http\Requests\LoginUserRequest;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    /**
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * login api
     *
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        $userDTO = new User();
        $userDTO->email = $request->email;
        $userDTO->password = $request->password;

        return $this->userService->apiAuthentication($userDTO);
    }

    public function logout()
    {
        return $this->userService->apiLogOut();
    }

}
