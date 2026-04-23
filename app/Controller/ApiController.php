<?php

namespace Controller;

use Src\Request;
use Src\View;
use Src\Session;
use Model\Staff;
use Model\Author;

class ApiController
{
    public function token(Request $request): void
    {
        $login = $request->login;
        $password = $request->password;

        $user = Staff::where('login', $login)->first();

        if (!$user || md5($password) !== $user->password) {
            (new View())->toJSON(['error' => 'Invalid credentials'], 401);
            return;
        }

        $token = md5($user->id_staff . time());
        Session::set('api_token', $token);

        (new View())->toJSON(['token' => $token]);
    }

    public function authors(Request $request): void
    {
        $authors = Author::all()->toArray();
        (new View())->toJSON($authors);
    }
}