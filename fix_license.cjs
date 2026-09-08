const fs = require('fs');
const file = 'routes/api.php';
let content = fs.readFileSync(file, 'utf8');

// Replace in checkout (free product)
const targetCheckoutFree = `                \\App\\Models\\UserLicense::create([
                    'user_id' => $order->user_id,
                    'product_id' => $purchasableModel->id,
                    'license_key' => 'DGTY-LIC-' . strtoupper(\\Illuminate\\Support\\Str::random(16)),
                    'status' => 'active',
                    'activated_at' => now(),
                ]);`;

const replacementCheckoutFree = `                \\App\\Models\\UserLicense::create([
                    'user_id' => $order->user_id,
                    'product_id' => $purchasableModel->id,
                    'pricing_id' => $pricingId,
                    'license_key' => 'DGTY-LIC-' . strtoupper(\\Illuminate\\Support\\Str::random(16)),
                    'status' => 'active',
                    'activated_at' => now(),
                ]);`;

// Replace in callback and mock-payment
const targetItemLoop = `                \\App\\Models\\UserLicense::create([
                    'user_id' => $order->user_id,
                    'product_id' => $item->purchasable_id,
                    'license_key' => 'DGTY-LIC-' . strtoupper(\\Illuminate\\Support\\Str::random(16)),
                    'status' => 'active',
                    'activated_at' => now(),
                ]);`;

const replacementItemLoop = `                \\App\\Models\\UserLicense::create([
                    'user_id' => $order->user_id,
                    'product_id' => $item->purchasable_id,
                    'pricing_id' => $item->pricing_id,
                    'license_key' => 'DGTY-LIC-' . strtoupper(\\Illuminate\\Support\\Str::random(16)),
                    'status' => 'active',
                    'activated_at' => now(),
                ]);`;

content = content.replace(targetCheckoutFree, replacementCheckoutFree);
// Use regex with global flag for the item loop since it appears twice
content = content.replace(new RegExp(targetItemLoop.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), replacementItemLoop);

fs.writeFileSync(file, content);
console.log("Updated UserLicense creation");
