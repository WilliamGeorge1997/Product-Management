<?php

namespace Modules\User\App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\DTO\UserDto;
use App\Http\Controllers\Controller;
use Modules\User\Service\UserAuthService;
use Modules\User\App\Http\Requests\UserRegisterRequest;

class UserAuthController extends Controller
{
    private $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function registerForm()
    {
        return view('user::user.auth.register');
    }

    public function register(UserRegisterRequest $request)
    {
        $data = (new UserDto($request))->dataFromRequest();
        $user = $this->userAuthService->register($data);
        return to_route('login.form')->with('success', 'User created successfully');
    }

    public function loginForm()
    {
        return view('user::user.auth.login');
    }

    public function login(UserRegisterRequest $request)
    {
        $data = (new UserDto($request))->dataFromRequest();
        $user = $this->userAuthService->login($data);
        dd($user);
        return to_route('login.form')->with('success', 'Welcome back ' . $user->name);
    }
}
