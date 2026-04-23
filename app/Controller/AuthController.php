<?php

namespace Controller;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Model\Token;
use Src\Validator\Validator;
// use Beavya\Validation\Validator;

class AuthController
{
    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        $validator = new Validator($request->all(), [
            'login' => ['required'],
            'password' => ['required'],
        ], [
            'required' => 'Поле :field пусто',
        ]);

        if ($validator->fails()) {
            return new View('site.login', [
                'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
            ]);
        }

        if (Auth::attempt($request->all())) {
            if (app()->auth::user()->id_role == 1) {
                app()->route->redirect('/add_librarian');
                return false;
            }

            app()->route->redirect('/books');
            return false;
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        app()->auth::logout();
        app()->route->redirect('/');
    }
}