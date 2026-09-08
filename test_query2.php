<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'testmidtrans@example.com')->first();
$orders = $user->orders()->with('items.product')->latest()->get();
echo "Success: " . count($orders) . " orders\n";
