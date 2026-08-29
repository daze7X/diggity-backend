import sys

def modify():
    with open('routes/api.php', 'r', encoding='utf-8') as f:
        content = f.read()

    new_route = """
// Get hierarchical categories for Products Mega Menu and Hub
Route::get('/products/hierarchy', function () {
    $mainCategories = \App\Models\Category::whereNull('parent_id')
        ->where('type', 'product')
        ->with(['children' => function($q) {
            $q->withCount(['products' => function($q2) {
                $q2->where('is_active', 'true');
            }]);
        }])
        ->get();
        
    return response()->json($mainCategories);
});

// Get products by subcategory
Route::get('/products/subcategory/{slug}', function ($slug) {
    $subCategory = \App\Models\Category::where('slug', $slug)
        ->whereNotNull('parent_id')
        ->where('type', 'product')
        ->with(['parent'])
        ->firstOrFail();
        
    $products = \App\Models\Product::where('category_id', $subCategory->id)
        ->where('is_active', 'true')
        ->get();
        
    return response()->json([
        'subcategory' => $subCategory,
        'products' => $products
    ]);
});

"""

    target = "Route::get('/products', function (\\Illuminate\\Http\\Request $request) {"
    
    if target in content and "/products/hierarchy" not in content:
        content = content.replace(target, new_route + target)
        with open('routes/api.php', 'w', encoding='utf-8') as f:
            f.write(content)
        print("Successfully added products hierarchy routes.")
    else:
        print("Target not found or already added.")

modify()
