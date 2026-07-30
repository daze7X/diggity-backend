<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/storage/{path}', function ($path) {
    $filePath = '/tmp/public/' . $path;
    if (file_exists($filePath)) {
        return response()->file($filePath);
    }
    
    $fallbackPath = storage_path('app/public/' . $path);
    if (file_exists($fallbackPath)) {
        return response()->file($fallbackPath);
    }
    
    abort(404);
})->where('path', '.*');
