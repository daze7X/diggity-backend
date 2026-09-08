<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$response = Http::withToken('4|DuKTOpS4gn4ZCHrXIBpR01uDMOE86TMbNDa9VsYib3992ca7')
    ->post('http://127.0.0.1:8080/api/checkout', [
        'purchasable_type' => 'product',
        'purchasable_id' => 69,
        'pricing_id' => 6,
    ]);

echo $response->body();
