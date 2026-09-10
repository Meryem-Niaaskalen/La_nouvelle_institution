<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $frontend = rtrim(config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:5173')), '/');

    return redirect()->away($frontend);
});
