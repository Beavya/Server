<?php

use Src\Route;

Route::add('POST', '/token', [Controller\AuthController::class, 'generateToken']);

Route::add('GET', '/authors', [Controller\ApiController::class, 'authors'])
    ->middleware('bearer');