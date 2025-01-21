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
            // Create new API token on login
            $token = $user->createToken('auth-token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token
            ];
        }
        return null;
    }
}
