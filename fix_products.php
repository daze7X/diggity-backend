<?php
$file = 'routes/api.php';
$content = file_get_contents($file);

$content = str_replace(
    "->licenses()->with('product')->get();",
    "->licenses()->with(['product.category', 'pricing'])->get();",
    $content
);

file_put_contents($file, $content);
echo "Updated /user/products eager loading\n";
