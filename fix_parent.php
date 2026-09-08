<?php
$file = 'routes/api.php';
$content = file_get_contents($file);

$content = str_replace(
    "->licenses()->with(['product.category', 'pricing'])->get();",
    "->licenses()->with(['product.category.parent', 'pricing'])->get();",
    $content
);

file_put_contents($file, $content);
echo "Updated /user/products to load category.parent\n";
