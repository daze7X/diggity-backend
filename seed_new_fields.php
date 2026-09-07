<?php
$products = \App\Models\Product::all();
$count = 0;

foreach($products as $p) {
    // Data Indonesia
    $p->benefits = ['Meningkatkan Efisiensi', 'Keamanan Terjamin', 'Skalabilitas Tinggi', 'Dukungan Cepat'];
    $p->use_cases = ['Bisnis Skala Menengah', 'Perusahaan Enterprise', 'Startup Digital'];
    $p->specifications = [
        'Platform' => 'Web & Cloud',
        'Lisensi' => 'Komersial (Tahunan)',
        'Update Sistem' => 'Otomatis'
    ];
    $p->integrations = ['Google Workspace', 'Stripe', 'WhatsApp Business', 'AWS Cloud'];
    $p->faq = [
        [
            'question' => 'Bagaimana proses instalasinya?',
            'answer' => 'Instalasi sangat mudah dan tim teknis kami akan mendampingi Anda hingga sistem berjalan 100%.'
        ],
        [
            'question' => 'Apakah ada biaya tambahan tersembunyi?',
            'answer' => 'Tidak. Semua biaya sudah transparan sesuai dengan paket yang tertera, mencakup server dan maintenance dasar.'
        ]
    ];

    // Data English
    $p->en_benefits = ['Increase Efficiency', 'Guaranteed Security', 'High Scalability', 'Fast Support'];
    $p->en_use_cases = ['Medium Businesses', 'Enterprise Companies', 'Digital Startups'];
    $p->en_specifications = [
        'Platform' => 'Web & Cloud',
        'License' => 'Commercial (Yearly)',
        'System Update' => 'Automatic'
    ];
    $p->en_integrations = ['Google Workspace', 'Stripe', 'WhatsApp Business', 'AWS Cloud'];
    $p->en_faq = [
        [
            'question' => 'How is the installation process?',
            'answer' => 'Installation is very easy and our technical team will assist you until the system is running 100%.'
        ],
        [
            'question' => 'Are there any hidden additional costs?',
            'answer' => 'No. All costs are transparent according to the listed package, covering servers and basic maintenance.'
        ]
    ];

    $p->save();
    $count++;
}

echo "Berhasil mengisi dummy data ke {$count} produk!\n";
