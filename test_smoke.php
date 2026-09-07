<?php
$p = \App\Models\Product::first();
if (!$p) {
    echo "No product found to test.\n";
    exit;
}

// Data Simulasi ID
$p->benefits = ['Hemat Waktu', 'Efisien'];
$p->specifications = [
    ['key' => 'Sistem Operasi', 'value' => 'Windows'],
    ['key' => 'Kapasitas', 'value' => '100GB']
];
$p->faq = [
    ['question' => 'Apakah gratis?', 'answer' => 'Tidak, berbayar.']
];

// Data Simulasi EN
$p->en_benefits = ['Save Time', 'Efficient'];
$p->en_specifications = [
    ['key' => 'Operating System', 'value' => 'Windows'],
    ['key' => 'Capacity', 'value' => '100GB']
];
$p->en_faq = [
    ['question' => 'Is it free?', 'answer' => 'No, it is paid.']
];

$p->save();
$p->refresh();

echo "\n====== TINKER SMOKE TEST RESULTS ======\n";
echo "[ID] Benefits: " . json_encode($p->benefits) . "\n";
echo "[EN] Benefits: " . json_encode($p->en_benefits) . "\n\n";

echo "[ID] Specifications: " . json_encode($p->specifications) . "\n";
echo "[EN] Specifications: " . json_encode($p->en_specifications) . "\n\n";

echo "[ID] FAQ: " . json_encode($p->faq) . "\n";
echo "[EN] FAQ: " . json_encode($p->en_faq) . "\n";
echo "=======================================\n";
