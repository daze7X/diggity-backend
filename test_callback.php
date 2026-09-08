<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Reset order status
$order = \App\Models\Order::where('order_number', 'DGTY-1788834821-2082')->first();
$order->payment_status = 'pending';
$order->status = 'pending';
$order->save();

// Delete old licenses
\App\Models\UserLicense::where('user_id', 5)->delete();

use Illuminate\Support\Facades\Http;

$response = Http::get('http://127.0.0.1:8080/api/payment/mock-payment?order=DGTY-1788834821-2082');
echo "Mock Payment Response Code: " . $response->status() . "\n";

// Check the DB if UserLicense was created with pricing_id
$license = App\Models\UserLicense::where('user_id', 5)->where('product_id', 69)->first();
if ($license) {
    echo "License Created!\n";
    echo "License Pricing ID: " . $license->pricing_id . "\n";
} else {
    echo "License NOT Created!\n";
}
