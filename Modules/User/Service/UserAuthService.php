<?php

namespace Modules\User\Service;

use Modules\User\App\Models\User;
use Modules\User\App\Http\Requests\UserRegisterRequest;

class UserAuthService
{
    public function register($data)
    {
        $user = User::create($data);
        return $user;
    }

    public function login($data)
    {
        if ($user = auth('client')->attempt($data)) {
            return $user;
        }
        return null;
    }
}
