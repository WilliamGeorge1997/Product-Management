<?php

namespace Modules\User\App\Http\Controllers;

use Modules\User\DTO\UserDto;
use App\Http\Controllers\Controller;
use Modules\User\Service\UserAuthService;
use Modules\User\App\Http\Requests\UserLoginRequest;
use Modules\User\App\Http\Requests\UserRegisterRequest;

class UserAuthController extends Controller
{
    private $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->middleware('guest:user-web')->except('logout');
        $this->middleware('auth:user-web')->only('logout');
        $this->middleware('prevent-back-history');
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
        if ($user)
            return to_route('login.form')->with('success', 'Your account has been created successfully, You can login now.');
        return to_route('register.form')->with('error', 'Something went wrong');
    }

    public function loginForm()
    {
        return view('user::user.auth.login');
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->only(['email', 'password']);
        $response = $this->userAuthService->login($data);
        if ($response) {
            return to_route('products.index')
                ->with('success', 'Welcome back ' . $response['user']->name)
                ->with('token', $response['token']);
        }
        return to_route('login.form')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        auth('user-web')->logout();
        return to_route('login.form')->with('success', 'You have been logged out successfully');
    }
}
