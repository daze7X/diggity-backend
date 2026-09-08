<?php
$file = 'routes/api.php';
$content = file_get_contents($file);

// Replace Validation
$content = preg_replace(
    "/'purchasable_id'\s*=>\s*'required\|integer',\s*\]\);/",
    "'purchasable_id' => 'required|integer',\n            'pricing_id' => 'nullable|integer',\n        ]);",
    $content
);

// Replace Price Logic
$content = preg_replace(
    "/\\\$purchasableModel = null;\s*\\\$price = 0;\s*\\\$itemName = '';\s*if \(\\\$type === 'product'\) \{\s*\\\$purchasableModel = \\\\App\\\\Models\\\\Product::findOrFail\(\\\$id\);\s*\\\$price = \\\$purchasableModel->price;\s*\\\$itemName = \\\$purchasableModel->name;/",
    "\$purchasableModel = null;\n        \$price = 0;\n        \$itemName = '';\n        \$pricingId = \$validated['pricing_id'] ?? null;\n        \$pricingModel = null;\n\n        if (\$type === 'product') {\n            \$purchasableModel = \App\Models\Product::findOrFail(\$id);\n            \$price = \$purchasableModel->price;\n            \$itemName = \$purchasableModel->name;\n\n            if (\$pricingId) {\n                \$pricingModel = \App\Models\Pricing::where('id', \$pricingId)\n                    ->where('product_id', \$id)\n                    ->whereIn('pricing_status', ['active', 'promotional'])\n                    ->firstOrFail();\n                \n                if (\$pricingModel->sale_price !== null && \$pricingModel->sale_price > 0) {\n                    \$price = \$pricingModel->sale_price;\n                } else {\n                    \$price = \$pricingModel->numeric_price;\n                }\n                \$itemName = \$purchasableModel->name . ' - ' . \$pricingModel->name;\n            }",
    $content
);

// Replace OrderItem Create
$content = preg_replace(
    "/'purchasable_id'\s*=>\s*\\\$purchasableModel->id,\s*'price'\s*=>\s*\\\$price,\s*'quantity'\s*=>\s*1,\s*\]\);/",
    "'purchasable_id' => \$purchasableModel->id,\n            'pricing_id' => \$pricingId ?? null,\n            'price' => \$price,\n            'quantity' => 1,\n        ]);",
    $content
);

// Replace Free UserLicense
$content = preg_replace(
    "/'product_id'\s*=>\s*\\\$purchasableModel->id,\s*'license_key'/",
    "'product_id' => \$purchasableModel->id,\n                    'pricing_id' => \$pricingId ?? null,\n                    'license_key'",
    $content
);

file_put_contents($file, $content);
echo "PHP Regex Replacement Done\n";
