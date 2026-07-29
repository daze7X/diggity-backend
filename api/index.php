<?php

try {
    // Forward all serverless requests to Laravel's public index entry point
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "<h1>Laravel Serverless Crash Report</h1>";
    
    // Check if there was a previous exception (the original error)
    $originalError = $e;
    while ($originalError->getPrevious() !== null) {
        $originalError = $originalError->getPrevious();
    }
    
    echo "<p><strong>Original Error Message:</strong> " . htmlspecialchars($originalError->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($originalError->getFile()) . " on line " . $originalError->getLine() . "</p>";
    echo "<p><strong>Code:</strong> " . $originalError->getCode() . "</p>";
    echo "<h2>Original Stack Trace:</h2>";
    echo "<pre>" . htmlspecialchars($originalError->getTraceAsString()) . "</pre>";
    
    echo "<hr><h2>Secondary Exception (Exception Handler Crash):</h2>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
