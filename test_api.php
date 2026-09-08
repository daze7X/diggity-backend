<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$user = App\Models\User::where('email', 'testmidtrans@example.com')->first();
if (!$user) {
    echo "No user";
    exit;
}
$token = clone $user;
$token = $token->createToken('test-token')->plainTextToken;

$response = Http::withToken($token)->get('http://127.0.0.1:8080/api/user/orders');
echo "Orders Response: " . $response->status() . "\n";
echo substr($response->body(), 0, 500);
