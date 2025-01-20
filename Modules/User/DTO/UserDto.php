<?php

namespace Modules\User\DTO;

class UserDto
{
    public string $name;
    public string $email;
    public string $password;

    public function __construct($request)
    {
        $this->name = $request->get('name');
        $this->email = $request->get('email');
        if ($request->get('password'))
            $this->password = bcrypt($request->get('password'));
    }

    public function dataFromRequest()
    {
        $data = json_decode(json_encode($this), true);
        if ($data['name'] == null)
            unset($data['name']);
        return $data;
    }
}
