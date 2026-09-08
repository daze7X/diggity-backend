<?php
$file = 'routes/api.php';
$content = file_get_contents($file);

$content = str_replace(
    "->with(['items.purchasable', 'items.pricing'])",
    "->with(['items.purchasable.category.parent', 'items.pricing'])",
    $content
);

file_put_contents($file, $content);
echo "Updated /user/orders to load category.parent\n";
