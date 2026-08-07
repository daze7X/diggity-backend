<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/seed-db', function () {
    try {
        Artisan::call('db:seed', ['--class' => 'DiggitySeeder', '--force' => true]);
        return response()->json([
            'status' => 'success',
            'message' => 'Database seeded successfully!',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
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
