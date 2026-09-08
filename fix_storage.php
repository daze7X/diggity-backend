<?php
$file = 'routes/api.php';
$content = file_get_contents($file);

$content = str_replace(
    "Storage::disk('public')->exists",
    "Storage::disk('local')->exists",
    $content
);
$content = str_replace(
    "Storage::disk('public')->download",
    "Storage::disk('local')->download",
    $content
);

file_put_contents($file, $content);
echo "Updated api.php to use local disk for secure downloads\n";
