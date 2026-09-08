const fs = require('fs');
const file = 'routes/api.php';
let content = fs.readFileSync(file, 'utf8');

const targetValidation = `$validated = $request->validate([
            'purchasable_type' => 'required|string|in:product,course',
            'purchasable_id' => 'required|integer',
        ]);`;

const replacementValidation = `$validated = $request->validate([
            'purchasable_type' => 'required|string|in:product,course',
            'purchasable_id' => 'required|integer',
            'pricing_id' => 'nullable|integer',
        ]);`;

content = content.replace(targetValidation, replacementValidation);

const targetPriceLogic = `        $purchasableModel = null;
        $price = 0;
        $itemName = '';

        if ($type === 'product') {
            $purchasableModel = \\App\\Models\\Product::findOrFail($id);
            $price = $purchasableModel->price;
            $itemName = $purchasableModel->name;`;

const replacementPriceLogic = `        $purchasableModel = null;
        $price = 0;
        $itemName = '';
        $pricingId = $validated['pricing_id'] ?? null;
        $pricingModel = null;

        if ($type === 'product') {
            $purchasableModel = \\App\\Models\\Product::findOrFail($id);
            $price = $purchasableModel->price;
            $itemName = $purchasableModel->name;

            if ($pricingId) {
                $pricingModel = \\App\\Models\\Pricing::where('id', $pricingId)
                    ->where('product_id', $id)
                    ->whereIn('pricing_status', ['active', 'promotional'])
                    ->firstOrFail();
                
                if ($pricingModel->sale_price !== null && $pricingModel->sale_price > 0) {
                    $price = $pricingModel->sale_price;
                } else {
                    $price = $pricingModel->numeric_price;
                }
                $itemName = $purchasableModel->name . ' - ' . $pricingModel->name;
            }`;

// Use proper regex replacement to ignore CR/LF differences
content = content.replace(new RegExp(targetPriceLogic.replace(/[.*+?^${}()|[\]\\]/g, '\\$&').replace(/\\n/g, '\\r?\\n'), 'g'), replacementPriceLogic);

// Wait, the first one:
content = content.replace(new RegExp(targetValidation.replace(/[.*+?^${}()|[\]\\]/g, '\\$&').replace(/\\n/g, '\\r?\\n'), 'g'), replacementValidation);

const targetOrderItem = `        // Create OrderItem
        \\App\\Models\\OrderItem::create([
            'order_id' => $order->id,
            'purchasable_type' => get_class($purchasableModel),
            'purchasable_id' => $purchasableModel->id,
            'price' => $price,
            'quantity' => 1,
        ]);`;

const replacementOrderItem = `        // Create OrderItem
        \\App\\Models\\OrderItem::create([
            'order_id' => $order->id,
            'purchasable_type' => get_class($purchasableModel),
            'purchasable_id' => $purchasableModel->id,
            'pricing_id' => $pricingId,
            'price' => $price,
            'quantity' => 1,
        ]);`;

content = content.replace(new RegExp(targetOrderItem.replace(/[.*+?^${}()|[\]\\]/g, '\\$&').replace(/\\n/g, '\\r?\\n'), 'g'), replacementOrderItem);

fs.writeFileSync(file, content);
console.log("Updated checkout endpoint properly");
