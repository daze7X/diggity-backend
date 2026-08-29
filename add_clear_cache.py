import sys

def modify():
    filepath = 'routes/api.php'
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    new_route = """
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    if (function_exists('opcache_reset')) {
        opcache_reset();
    }
    return response()->json(['status' => 'success', 'message' => 'Cache and OPcache cleared!']);
});
"""
    if '/clear-cache' not in content:
        content += new_route

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Added /api/clear-cache route.")

modify()
