<?php
$file = 'app/Filament/Resources/Products/Schemas/ProductForm.php';
if (file_exists($file)) {
    $content = file_get_contents($file);
    $content = str_replace(
        "->directory('product_files')",
        "->disk('local')->directory('product_files')",
        $content
    );
    file_put_contents($file, $content);
    echo "Updated ProductForm.php\n";
} else {
    echo "ProductForm.php not found\n";
}
