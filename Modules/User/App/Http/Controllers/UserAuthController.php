<?php

namespace Modules\User\App\Http\Controllers;

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
        $this->middleware('guest:user-web')->except('logout');
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
            $cookie = cookie('sanctum_token', $response['token'], 60 * 24, '/', null, true, true, false);
            return redirect()
                ->route('products.index')
                ->with('success', 'Welcome back ' . $response['user']->name)
                ->withCookie($cookie);
        }
        return to_route('login.form')->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        $response = $this->userAuthService->logout();
        if ($response) {
            return to_route('login.form')
                ->with('success', 'You have been logged out successfully');
        }
        return to_route('login.form')->with('error', 'Something went wrong');
    }
}
