<?php
$file = 'routes/api.php';
$content = file_get_contents($file);

$content = preg_replace(
    "/'product_id'\s*=>\s*\\\$item->purchasable_id,\s*'license_key'/",
    "'product_id' => \$item->purchasable_id,\n                    'pricing_id' => \$item->pricing_id,\n                    'license_key'",
    $content
);

file_put_contents($file, $content);
echo "Updated mock payment with pricing_id\n";
