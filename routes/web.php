<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('WelcomePage');
});

Route::get('/login', function () {
    return inertia('LoginPage');
});
