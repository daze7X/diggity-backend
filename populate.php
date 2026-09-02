<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::all();

$features = [
    "Real-time Analytics & Reporting",
    "Role-based Access Control (RBAC)",
    "End-to-End Data Encryption",
    "Seamless API Integrations",
    "Scalable Cloud Architecture",
    "24/7 Premium Support"
];

$gallery = [
    "https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1000",
    "https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1000"
];

$licenseInfo = "Lisensi tahunan (Annual Subscription) kelas Enterprise. Mencakup pembaruan sistem otomatis, perlindungan keamanan tingkat lanjut, dan garansi perbaikan bug penuh selama masa aktif berlangganan.";

$count = 0;
foreach ($products as $product) {
    // Only update if they are empty or just update all? I will update all to ensure consistency.
    $product->features = $features;
    $product->gallery = $gallery;
    $product->license_info = $licenseInfo;
    $product->save();
    $count++;
}

echo "Successfully updated $count products with dummy features, gallery, and license info.\n";
