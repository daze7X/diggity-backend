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

const targetPriceLogic = `$purchasableModel = null;
        $price = 0;
        $itemName = '';

        if ($type === 'product') {
            $purchasableModel = \\App\\Models\\Product::findOrFail($id);
            $price = $purchasableModel->price;
            $itemName = $purchasableModel->name;`;

const replacementPriceLogic = `$purchasableModel = null;
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

content = content.replace(targetValidation, replacementValidation);
content = content.replace(targetPriceLogic, replacementPriceLogic);
content = content.replace(targetOrderItem, replacementOrderItem);

fs.writeFileSync(file, content);
console.log("Updated checkout endpoint");
