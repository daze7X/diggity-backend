<?php

// Force the script name on Vercel to prevent Laravel from detecting '/api' as the base URL
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

try {
    // Register the Composer autoloader
    require_once __DIR__ . '/../vendor/autoload.php';

    // Set writable cache paths for Vercel serverless environment
    putenv('APP_SERVICES_CACHE=/tmp/services.php');
    putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
    putenv('APP_CONFIG_CACHE=/tmp/config.php');
    putenv('APP_ROUTES_CACHE=/tmp/routes-v7.php');
    putenv('APP_EVENTS_CACHE=/tmp/events.php');
    $_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
    $_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
    $_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
    $_ENV['APP_ROUTES_CACHE'] = '/tmp/routes-v7.php';
    $_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';

    // Load the Laravel application
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    $app->useStoragePath('/tmp');
    
    // Capture the request early
    $request = Illuminate\Http\Request::capture();
    
    // Bind the request instance to the container so that bootstrap-time helpers (like asset() or route()) work
    $app->instance('request', $request);
    
    // Resolve the HTTP kernel
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Boot the kernel bootstrappers manually in a try-catch to bypass the exception handler crash
    $kernel->bootstrap();
    
    // Handle the request normally if bootstrap succeeded
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
