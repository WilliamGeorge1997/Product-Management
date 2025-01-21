<?php

namespace Modules\User\App\Http\Controllers\api;

use Modules\User\DTO\UserDto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Modules\User\Service\UserAuthService;
use Modules\User\App\Http\Requests\UserLoginRequest;
use Modules\User\App\Http\Requests\UserRegisterRequest;

class UserAuthController extends Controller
{
    private $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->middleware('guest:user-api')->except('logout');
        $this->middleware('prevent-back-history');
        $this->userAuthService = $userAuthService;
    }


    public function register(UserRegisterRequest $request)
    {
        $data = (new UserDto($request))->dataFromRequest();
        $user = $this->userAuthService->register($data);
        if ($user)
            return response()->json(['message' => 'Your account has been created successfully, You can login now.'], 201);
        return response()->json(['error' => 'Something went wrong'], 400);
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->only(['email', 'password']);
        $response = $this->userAuthService->login($data);

        if ($response) {
            return response()->json([
                'message' => 'Welcome back ' . $response['user']->name,
                'token' => $response['token']
            ], 200);
        }
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $response = $this->userAuthService->logout();
        if ($response) {
            return response()->json(['message' => 'You have been logged out successfully'], 200);
        }
        return response()->json(['error' => 'Something went wrong'], 400);
    }
}
