<?php
$file = 'routes/api.php';
$content = file_get_contents($file);

$content = str_replace(
    "->with('items.product')",
    "->with(['items.purchasable', 'items.pricing'])",
    $content
);

file_put_contents($file, $content);
echo "Updated /user/orders eager loading\n";
