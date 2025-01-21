<?php

namespace Modules\User\Service;

use Modules\User\App\Models\User;

class UserAuthService
{
    public function register($data)
    {
        $user = User::create($data);
        return $user;
    }

    public function login($data)
    {
        if (auth('user-web')->attempt($data)) {
            $user = auth('user-web')->user();
            $user->tokens()->delete();
            $token = $user->createToken('sanctum_token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token,
            ];
        }
        return null;
    }

    public function logout()
    {
        if (request()->hasCookie('sanctum_token')) {
            cookie()->queue(cookie()->forget('sanctum_token'));
        }
        auth('user-web')->user()->tokens()->delete();
        auth('user-web')->logout();
        return true;
    }
}
