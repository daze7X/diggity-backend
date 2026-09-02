import sys

filepath = 'routes/api.php'

with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# Add the new route at the end of the file
new_route = """
// GET /api/update-product-features
Route::get('/update-product-features', function () {
    try {
        $products = \\App\\Models\\Product::all();
        
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
            $product->features = $features;
            $product->gallery = $gallery;
            $product->license_info = $licenseInfo;
            $product->save();
            $count++;
        }

        return response()->json([
            'status'  => 'success',
            'message' => "Successfully updated $count products with dummy features, gallery, and license info."
        ]);
    } catch (\\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
"""

if "// GET /api/update-product-features" not in content:
    content = content + new_route
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Added update-product-features route.")
else:
    print("Route already exists.")
