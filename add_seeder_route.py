import sys
import re

def modify():
    filepath = 'routes/api.php'
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Add the run-products-seeder route
    new_route = """
// GET /api/run-products-seeder
Route::get('/run-products-seeder', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => 'ProductsRestructureSeeder',
            '--force' => true,
        ]);
        return response()->json([
            'status'  => 'success',
            'message' => 'ProductsRestructureSeeder ran successfully!',
            'output'  => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
"""
    if '/run-products-seeder' not in content:
        content += new_route

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Added /api/run-products-seeder route.")

modify()
