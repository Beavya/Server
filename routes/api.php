<?php

use Src\Route;

Route::add('POST', '/token', [Controller\ApiController::class, 'token']);

Route::add('GET', '/authors', [Controller\ApiController::class, 'authors'])
    ->middleware('bearer');