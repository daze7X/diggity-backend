<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Product;
use App\Models\Pricing;
use App\Models\Category;

$cat = Category::firstOrCreate(['slug' => 'test-cat'], ['name' => 'Test Cat', 'type' => 'product']);

$user = User::firstOrCreate(
    ['email' => 'testmidtrans@example.com'],
    ['name' => 'Midtrans Tester', 'password' => bcrypt('password')]
);
// drop all previous tokens
$user->tokens()->delete();
$token = $user->createToken('test-token')->plainTextToken;

$product = Product::firstOrCreate(
    ['slug' => 'test-product-midtrans'],
    [
        'name' => 'E2E Test Product',
        'description' => 'Test',
        'price' => 50000,
        'category_id' => $cat->id,
        'is_active' => true
    ]
);

$pricing = Pricing::updateOrCreate(
    ['product_id' => $product->id, 'name' => 'Commercial License'],
    [
        'pricing_type' => 'one_time',
        'numeric_price' => 299000,
        'price' => 'Rp 299.000',
        'features' => ['test'],
        'pricing_status' => 'active',
        'license_type' => 'Commercial'
    ]
);

echo "TOKEN:" . $token . "|PROD:" . $product->id . "|PRICE:" . $pricing->id;
