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

Route::get('/test-s3', function () {
    try {
        $disk = \Illuminate\Support\Facades\Storage::disk('s3');
        
        $put = $disk->put('test-diagnostic.txt', 'Hello from Vercel S3 Test at ' . now()->toDateTimeString());
        $copy = $disk->copy('test-diagnostic.txt', 'blogs/test-copy.txt');
        $existsCopy = $disk->exists('blogs/test-copy.txt');
        $deleteCopy = $existsCopy ? $disk->delete('blogs/test-copy.txt') : false;
        $exists = $disk->exists('test-diagnostic.txt');
        $content = $exists ? $disk->get('test-diagnostic.txt') : 'N/A';
        $delete = $exists ? $disk->delete('test-diagnostic.txt') : false;
        
        return response()->json([
            'status' => 'success',
            'put' => $put,
            'copy' => $copy,
            'exists_copy' => $existsCopy,
            'delete_copy' => $deleteCopy,
            'exists' => $exists,
            'content' => $content,
            'delete' => $delete,
            'driver' => config('filesystems.disks.s3.driver'),
            'endpoint' => config('filesystems.disks.s3.endpoint'),
            'bucket' => config('filesystems.disks.s3.bucket'),
            'default_disk' => config('filesystems.default'),
            'form_disk' => env('FILESYSTEM_DISK', 'public'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'endpoint' => config('filesystems.disks.s3.endpoint'),
            'bucket' => config('filesystems.disks.s3.bucket'),
        ], 500);
    }
});

Route::get('/list-s3', function () {
    try {
        $disk = \Illuminate\Support\Facades\Storage::disk('s3');
        $files = $disk->allFiles();
        return response()->json([
            'status' => 'success',
            'files' => $files,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
});

Route::get('/check-users', function () {
    try {
        return response()->json([
            'status' => 'success',
            'users' => \App\Models\User::all(['id', 'name', 'email'])->toArray()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
});
