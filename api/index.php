<?php

try {
    // Register the Composer autoloader
    require_once __DIR__ . '/../vendor/autoload.php';

    // Load the Laravel application
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Resolve the HTTP kernel
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Boot the kernel bootstrappers manually in a try-catch to bypass the exception handler crash
    $kernel->bootstrap();
    
    // Handle the request normally if bootstrap succeeded
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "<h1>Original Laravel Bootstrap Exception Caught!</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " on line " . $e->getLine() . "</p>";
    echo "<p><strong>Class:</strong> " . get_class($e) . "</p>";
    echo "<h2>Stack Trace:</h2>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
