<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/seed-db', function () {
    try {
        Artisan::call('db:seed', ['--class' => 'DiggitySeeder', '--force' => true]);
        return response()->json([
            'status' => 'success',
            'message' => 'Database seeded successfully!',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/migrate-db', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return response()->json([
            'status' => 'success',
            'message' => 'Database migrated successfully!',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/seed-services', function () {
    try {
        $catApp = \App\Models\Category::updateOrCreate(['name' => 'App Builder Squad'], ['slug' => 'app-builder-squad', 'type' => 'service']);
        $catBrand = \App\Models\Category::updateOrCreate(['name' => 'Brand Growth Division'], ['slug' => 'brand-growth-division', 'type' => 'service']);
        $catCloud = \App\Models\Category::updateOrCreate(['name' => 'Cloud Service Hub'], ['slug' => 'cloud-service-hub', 'type' => 'service']);
        $catLab = \App\Models\Category::updateOrCreate(['name' => 'Digital Skill Lab'], ['slug' => 'digital-skill-lab', 'type' => 'service']);

        \App\Models\Service::updateOrCreate(
            ['slug' => 'technology-solutions'],
            [
                'category_id' => $catApp->id,
                'name' => 'Technology Solutions',
                'description' => 'Membangun website modern, aplikasi mobile native, dan kustomisasi sistem ERP terintegrasi berkecepatan tinggi.',
                'icon' => 'code',
                'sub_services' => [
                    'Website Development (Next.js, React, Laravel)',
                    'Mobile Apps Development (iOS & Android Native)',
                    'Custom Software & ERP Systems Development',
                    'Custom E-Commerce & Retail Platform Engineering',
                    'Government Digital Services & Portal Solutions',
                    'API Design & Core Systems Integration'
                ],
                'plans' => [
                    [
                        'name' => 'Basic Web & Portal',
                        'price' => 'Mulai Rp 5.000.000',
                        'description' => 'Ideal untuk pendaratan produk awal, web profil perusahaan (company profile) berkinerja tinggi, dan optimasi SEO.',
                        'features' => [
                            'Responsive Design (Desktop & Mobile)',
                            'Hingga 5 Halaman Konten Utama',
                            'Integrasi WhatsApp & Sosial Media CTA',
                            'Analitik Google & Search Console Setup',
                            'Panduan Penggunaan Admin Panel'
                        ],
                        'isPopular' => false
                    ],
                    [
                        'name' => 'Custom Web & Mobile App',
                        'price' => 'Mulai Rp 15.000.000',
                        'description' => 'Ideal untuk bisnis yang membutuhkan portal interaktif khusus, aplikasi e-commerce ritel, atau aplikasi Android & iOS.',
                        'features' => [
                            'Desain UI/UX Kustom Eksklusif (Figma)',
                            'Aplikasi Mobile Native (iOS & Android)',
                            'CMS Manajemen Konten Dinamis',
                            'Integrasi Payment Gateway & Kurir Ekspedisi',
                            'Keamanan Enkripsi SSL & Sertifikat Keamanan'
                        ],
                        'isPopular' => true
                    ],
                    [
                        'name' => 'Enterprise Custom & ERP',
                        'price' => 'Mulai Rp 45.000.000',
                        'description' => 'Didesain khusus untuk integrasi skala besar, manajemen rantai pasok (ERP), pergudangan, keuangan, dan kustomisasi kompleks.',
                        'features' => [
                            'Arsitektur Multi-Role Access Control (RBAC)',
                            'Integrasi Sistem ERP & CRM Dinamis',
                            'Sinkronisasi Sistem Warisan & API Pihak Ketiga',
                            'Uji Beban Performa & Keamanan Siber Ketat',
                            'Dukungan SLA Pemeliharaan 24/7'
                        ],
                        'isPopular' => false
                    ]
                ]
            ]
        );

        \App\Models\Service::updateOrCreate(
            ['slug' => 'ai-emerging-technology'],
            [
                'category_id' => $catApp->id,
                'name' => 'AI & Emerging Technology',
                'description' => 'Integrasi asisten kecerdasan buatan, chatbot otomatisasi bisnis, machine learning, dan rekayasa data analitik.',
                'icon' => 'cpu',
                'sub_services' => [
                    'Artificial Intelligence & Agent Development',
                    'Smart AI Chatbots & Customer Assistants',
                    'Machine Learning Models & Integration',
                    'Business Intelligence & Big Data Analytics',
                    'IoT (Internet of Things) Hardware/Software Solutions',
                    'Robotic Process Automation (RPA)'
                ],
                'plans' => [
                    [
                        'name' => 'AI Assistant Chatbot',
                        'price' => 'Mulai Rp 7.500.000',
                        'description' => 'Integrasi asisten virtual kecerdasan buatan terlatih untuk melayani tanya jawab pelanggan otomatis selama 24 jam.',
                        'features' => [
                            'Integrasi Model OpenAI GPT / Gemini LLM',
                            'Custom Knowledge Base (Buku Panduan Bisnis)',
                            'Kanal Chat (WhatsApp, Telegram, atau Web)',
                            'Sistem Eskalasi ke Admin Manusia',
                            'Laporan Riwayat Percakapan Chatbot'
                        ],
                        'isPopular' => false
                    ],
                    [
                        'name' => 'AI Automation Agent',
                        'price' => 'Mulai Rp 20.000.000',
                        'description' => 'Otomatisasi proses bisnis internal perusahaan (RPA) menggunakan kecerdasan buatan untuk menghemat waktu kerja operasional.',
                        'features' => [
                            'Otomatisasi Alur Input Data & Dokumen',
                            'Pengenalan Karakter Gambar (AI OCR Engine)',
                            'Autopilot Sistem Operasional Harian',
                            'Notifikasi Alert & Sinkronisasi DB',
                            'Dashboard Efisiensi Kinerja Alur Kerja'
                        ],
                        'isPopular' => true
                    ],
                    [
                        'name' => 'Enterprise AI & BI Models',
                        'price' => 'Mulai Rp 60.000.000',
                        'description' => 'Pengembangan model mesin pembelajaran kustom, data engineering berskala besar, dan visualisasi analisis bisnis interaktif.',
                        'features' => [
                            'Pelatihan Model Machine Learning Kustom',
                            'Data Pipeline & Pembersihan Big Data',
                            'Prediksi Tren Penjualan & Perilaku Klien',
                            'Dashboard Business Intelligence Real-Time',
                            'Advisory Keamanan Data & Proteksi Privasi'
                        ],
                        'isPopular' => false
                    ]
                ]
            ]
        );

        \App\Models\Service::updateOrCreate(
            ['slug' => 'creative-brand-experience'],
            [
                'category_id' => $catBrand->id,
                'name' => 'Creative & Brand Experience',
                'description' => 'Perancangan antarmuka pengguna (UI/UX), perancangan identitas visual brand, kampanye kreatif, dan aset multimedia.',
                'icon' => 'palette',
                'sub_services' => [
                    'Brand Strategy, Naming & Consulting',
                    'Corporate Branding & Visual Identity System',
                    'UI/UX Design, Figma Wireframing & Prototyping',
                    'Professional Photography & High-End Videography',
                    'Motion Graphics & 2D/3D Animation Assets',
                    'Creative Advertising Campaigns & Collaterals'
                ],
                'plans' => [
                    [
                        'name' => 'Brand Identity Essentials',
                        'price' => 'Mulai Rp 3.500.000',
                        'description' => 'Penyusunan pondasi identitas visual brand yang solid untuk menarik minat pembeli pertama secara konsisten.',
                        'features' => [
                            'Desain Logo Utama & Alternatif',
                            'Sistem Palet Warna & Tipografi Resmi',
                            'Brand Guidelines Book (Panduan Visual)',
                            'Desain Kartu Nama & Kop Surat Perusahaan',
                            'Aset Media Sosial Awal (Banner & Avatar)'
                        ],
                        'isPopular' => false
                    ],
                    [
                        'name' => 'UI/UX Design Pro',
                        'price' => 'Mulai Rp 10.000.000',
                        'description' => 'Perancangan desain antarmuka aplikasi web dan mobile yang estetik, intuitif, berorientasi konversi, dan ramah pengguna.',
                        'features' => [
                            'Uji Coba Pengalaman Pengguna (UX Research)',
                            'Desain Kawat Kasar (Wireframing & Sitemap)',
                            'Desain Visual Beresolusi Tinggi (UI Mockup)',
                            'Prototipe Interaktif Siap Uji Pengguna',
                            'Sistem Desain Komponen Figma Terorganisir'
                        ],
                        'isPopular' => true
                    ],
                    [
                        'name' => 'Full Creative Campaigns',
                        'price' => 'Mulai Rp 25.000.000',
                        'description' => 'Produksi aset multimedia kreatif tingkat lanjut untuk mendominasi kesadaran publik di berbagai kanal media sosial.',
                        'features' => [
                            'Sesi Foto Produk & Profil Korporasi Profesional',
                            'Produksi Video Iklan & Company Profile',
                            'Aset Motion Graphics & Animasi 2D/3D',
                            'Desain Konten Kampanye Iklan Berbayar',
                            'Penyusunan Strategi Arah Kreatif (Creative Direction)'
                        ],
                        'isPopular' => false
                    ]
                ]
            ]
        );

        \App\Models\Service::updateOrCreate(
            ['slug' => 'growth-marketing'],
            [
                'category_id' => $catBrand->id,
                'name' => 'Growth Marketing',
                'description' => 'Optimasi SEO secara menyeluruh, kampanye iklan digital (Google/Meta Ads), dan optimasi tingkat konversi.',
                'icon' => 'trending-up',
                'sub_services' => [
                    'Search Engine Optimization (SEO) & Audits',
                    'Google Ads & Search Engine Marketing (SEM)',
                    'Meta Ads (Facebook, Instagram & Audience Network)',
                    'TikTok & Social Media Influencer Sourcing',
                    'Social Media Management & Organic Growth Strategy',
                    'Marketplace Store Optimization & Ads (Shopee/Tokopedia)'
                ],
                'plans' => [
                    [
                        'name' => 'SEO Dominance Essentials',
                        'price' => 'Mulai Rp 4.000.000',
                        'description' => 'Optimasi mesin pencari organik untuk meningkatkan peringkat website kawan secara dominan di hasil pencarian Google.',
                        'features' => [
                            'Riset Kata Kunci & Pemetaan Topik',
                            'Audit Teknis SEO & Kecepatan Website',
                            'Optimasi Konten On-Page & Copywriting',
                            'Laporan Bulanan Peringkat & Lalu Lintas Web',
                            'Optimasi Google My Business & SEO Lokal'
                        ],
                        'isPopular' => false
                    ],
                    [
                        'name' => 'Digital Ads & PPC Campaign',
                        'price' => 'Mulai Rp 7.000.000',
                        'description' => 'Kampanye iklan berbayar dengan target audiens presisi tinggi untuk menghasilkan leads instan dan penjualan secara cepat.',
                        'features' => [
                            'Setup Google Search & Display Ads',
                            'Manajemen Facebook & Instagram Meta Ads',
                            'Optimasi Iklan Video Pendek TikTok Ads',
                            'Perancangan Landing Page Khusus Konversi',
                            'Retargeting & Uji Coba Variasi Iklan (A/B Testing)'
                        ],
                        'isPopular' => true
                    ],
                    [
                        'name' => 'Total Organic Growth',
                        'price' => 'Mulai Rp 12.000.000',
                        'description' => 'Manajemen digital marketing komprehensif untuk mendongkrak reputasi brand secara organik dan sistematis.',
                        'features' => [
                            'Penyusunan Kalender Konten Media Sosial',
                            'Desain Grafis Konten Feed & Reels Kreatif',
                            'Outreach Influencer & Content Creator Sourcing',
                            'Setup Live Commerce & Penjualan Siaran Langsung',
                            'Optimasi Toko Marketplace (Shopee/Tokopedia)'
                        ],
                        'isPopular' => false
                    ]
                ]
            ]
        );

        \App\Models\Service::updateOrCreate(
            ['slug' => 'cloud-cyber-security'],
            [
                'category_id' => $catCloud->id,
                'name' => 'Cloud & Cyber Security',
                'description' => 'Penyediaan hosting server, konfigurasi VPS cloud server, pemeliharaan DevOps, dan audit perlindungan keamanan siber.',
                'icon' => 'server',
                'sub_services' => [
                    'Premium Cloud Hosting & Server Provisioning',
                    'VPS (Virtual Private Server) Configurations',
                    'DevOps Orchestration & Continuous Delivery (CI/CD)',
                    'Cyber Security Audits & Compliance Assessment',
                    'Penetration Testing & Vulnerability Assessment',
                    'Managed Cloud Infrastructure & SLA Support'
                ],
                'plans' => [
                    [
                        'name' => 'Cloud Setup & VPS Hosting',
                        'price' => 'Mulai Rp 3.000.000',
                        'description' => 'Penyusunan arsitektur server cloud yang andal, aman, berbiaya efisien, dan siap menghadapi lonjakan pengunjung.',
                        'features' => [
                            'Instalasi Server VPS (AWS, GCP, DigitalOcean)',
                            'Migrasi Database Tanpa Downtime Operasional',
                            'Setup Nama Domain & DNS Lanjutan',
                            'Setup Email Bisnis Resmi Kapasitas Besar',
                            'Konfigurasi Firewall & SSL Pengaman Enkripsi'
                        ],
                        'isPopular' => false
                    ],
                    [
                        'name' => 'DevOps & Infrastructure Automation',
                        'price' => 'Mulai Rp 12.000.000',
                        'description' => 'Otomatisasi deployment kode program untuk mempercepat rilis fitur baru developer secara aman tanpa kendala infrastruktur.',
                        'features' => [
                            'Setup Pipeline Otomatisasi (CI/CD)',
                            'Orkestrasi Container Docker / Kubernetes',
                            'Auto-Scaling Server Sesuai Beban Trafik',
                            'Sistem Pemantauan Performa Server Real-Time',
                            'Sistem Backup Cadangan Server Otomatis'
                        ],
                        'isPopular' => true
                    ],
                    [
                        'name' => 'Cyber Security Audit & Pentest',
                        'price' => 'Mulai Rp 25.000.000',
                        'description' => 'Audit pertahanan sistem informasi dan simulasi penyerangan (pentest) untuk menutup kerentanan keamanan siber.',
                        'features' => [
                            'Simulasi Penetrasi Keamanan Aplikasi (Pentest)',
                            'Pemindaian Celah Kerentanan Sistem (Vulnerability Scan)',
                            'Audit Kepatuhan Standardisasi Keamanan Informasi',
                            'Laporan Rekomendasi Penambalan Kode Program',
                            'Setup Sistem Deteksi Gangguan (IDS/IPS)'
                        ],
                        'isPopular' => false
                    ]
                ]
            ]
        );

        \App\Models\Service::updateOrCreate(
            ['slug' => 'consulting'],
            [
                'category_id' => $catCloud->id,
                'name' => 'Consulting',
                'description' => 'Layanan penasihat teknologi (Advisory), IT Consulting, audit digital, dan perumusan strategi transformasi bisnis.',
                'icon' => 'help-circle',
                'sub_services' => [
                    'IT Consulting & Technical Feasibility Studies',
                    'Corporate Digital Transformation Advisory',
                    'Enterprise Software Architecture Design',
                    'System Auditing & Technology Maturity Assessment'
                ],
                'plans' => [
                    [
                        'name' => 'Tech Feasibility Study',
                        'price' => 'Mulai Rp 5.000.000',
                        'description' => 'Studi kelayakan teknis dan analisis kebutuhan arsitektur sebelum perusahaan memulai investasi perangkat lunak baru.',
                        'features' => [
                            'Analisis Kebutuhan Sistem & Kelayakan Kode',
                            'Rekomendasi Pilihan Teknologi Stack Terbaik',
                            'Estimasi Kebutuhan Waktu & Biaya Dev',
                            'Analisis Risiko Teknis & Celah Kegagalan',
                            'Dokumen Blueprint Spesifikasi Kebutuhan Sistem'
                        ],
                        'isPopular' => false
                    ],
                    [
                        'name' => 'Digital Transformation Advisory',
                        'price' => 'Mulai Rp 15.000.000',
                        'description' => 'Layanan penasihat transformasi digital untuk modernisasi alur kerja perusahaan konvensional ke ranah digital.',
                        'features' => [
                            'Audit Kesiapan Teknologi Internal Perusahaan',
                            'Penyusunan Peta Jalan Transformasi Sistem',
                            'Rekomendasi Software & Integrasi Cloud',
                            'Analisis Efisiensi Biaya Operasional Teknologi',
                            'Sesi Pelatihan Adaptasi Perubahan Karyawan'
                        ],
                        'isPopular' => true
                    ],
                    [
                        'name' => 'Enterprise Tech Architecture Advisory',
                        'price' => 'Mulai Rp 35.000.000',
                        'description' => 'Penasihat arsitektur teknologi berkelanjutan berskala enterprise untuk mendukung keberlanjutan bisnis jangka panjang.',
                        'features' => [
                            'Desain Arsitektur Sistem Terdistribusi',
                            'Tata Kelola Risiko & Perlindungan Data Korporat',
                            'Advisory Pihak Ketiga & Integrasi API Vendor',
                            'Pengawasan Rilis Deploy Sistem Berskala Besar',
                            'Advisory CTO Independen untuk Board Management'
                        ],
                        'isPopular' => false
                    ]
                ]
            ]
        );

        \App\Models\Service::updateOrCreate(
            ['slug' => 'digital-skill-lab'],
            [
                'category_id' => $catLab->id,
                'name' => 'Digital Skill Lab',
                'description' => 'Meningkatkan kompetensi teknis tim internal perusahaan Anda agar siap bersaing di tengah pesatnya perkembangan transformasi teknologi digital.',
                'icon' => 'graduation-cap',
                'sub_services' => [
                    'Corporate IT Training & Bootcamps',
                    'Figma UI/UX & Design Workshops',
                    'Custom Software Development Workshop',
                    'Digital Marketing Masterclass & Analytics'
                ],
                'plans' => [
                    [
                        'name' => 'Introductory Session',
                        'price' => 'Mulai Rp 1.500.000',
                        'description' => 'Sesi pengenalan singkat 1 hari untuk membekali tim Anda dengan pemahaman dasar tool/teknologi spesifik.',
                        'features' => [
                            'Durasi 3-4 Jam Sesi Intensif',
                            'Sertifikat Keikutsertaan Resmi',
                            'Materi & Modul Pelatihan PDF',
                            'Q&A Langsung dengan Praktisi Ahli',
                            'Maksimal 15 Peserta per Sesi'
                        ],
                        'isPopular' => false
                    ],
                    [
                        'name' => 'Intensive Bootcamp',
                        'price' => 'Mulai Rp 10.000.000',
                        'description' => 'Program pelatihan mendalam selama 2 minggu untuk integrasi keahlian pemrograman, desain, atau marketing modern.',
                        'features' => [
                            'Kurikulum Kustom Sesuai Kebutuhan Bisnis',
                            'Sesi Praktik Kerja Nyata / Hands-on Lab',
                            'Evaluasi Kompetensi Individu Peserta',
                            'Sertifikat Kelulusan Resmi Digital Specialist',
                            'Maksimal 30 Peserta per Kelas'
                        ],
                        'isPopular' => true
                    ],
                    [
                        'name' => 'Custom Enterprise Syllabus',
                        'price' => 'Hubungi Kami',
                        'description' => 'Program pelatihan kustom jangka panjang dengan kurikulum berskala besar yang dirancang khusus untuk divisi IT enterprise.',
                        'features' => [
                            'Penyusunan Silabus Khusus oleh Tech Lead',
                            'Pelatihan Skala Divisi & Uji Kompetensi Lanjut',
                            'Studi Kasus Arsitektur Software Perusahaan',
                            'Pendampingan Pasca-Pelatihan Selama 30 Hari',
                            'Kuota Peserta Tidak Terbatas'
                        ],
                        'isPopular' => false
                    ]
                ]
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Services and Digital Skill Lab seeded successfully! 100% safe, did not touch other tables.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/seed-about', function () {
    try {
        \App\Models\CompanySetting::updateOrCreate(
            ['email' => 'hello@diggity.com'],
            [
                'name' => 'Diggity Agency',
                'whatsapp' => '628123456789',
                'address' => 'Gedung Digital Hub, Lt. 5, Jl. Technopark No. 12, BSD City, Tangerang',
                'instagram_url' => 'https://instagram.com/diggity.agency',
                'linkedin_url' => 'https://linkedin.com/company/diggity-agency',
                'vision_id' => 'Menjadi mitra transformasi digital terdepan di Asia Tenggara yang memberdayakan bisnis untuk bertumbuh secara terstruktur dan berkelanjutan melalui teknologi, kreativitas, dan edukasi terintegrasi.',
                'vision_en' => 'To be the leading digital transformation partner in Southeast Asia, empowering businesses to grow in a structured and sustainable manner through integrated technology, creativity, and education.',
                'mission_id' => [
                    ['text' => 'Rekayasa Software Berkualitas: Membangun infrastruktur dan produk digital berkinerja tinggi, aman, dan mudah diskalakan.'],
                    ['text' => 'Pertumbuhan Bisnis Terarah: Membantu mitra bisnis mendominasi pasar digital secara sistematis melalui pemasaran berbasis performa dan data.'],
                    ['text' => 'Transfer Pengetahuan Berkelanjutan: Melatih talenta internal mitra bisnis untuk menguasai keterampilan digital yang relevan dengan kebutuhan industri.']
                ],
                'mission_en' => [
                    ['text' => 'Quality Software Engineering: Building high-performance, secure, and scalable digital products and infrastructure.'],
                    ['text' => 'Targeted Business Growth: Helping business partners dominate the digital market systematically through performance- and data-driven marketing.'],
                    ['text' => 'Sustainable Knowledge Transfer: Training partners\' internal talents to master relevant digital skills that align with industry needs.']
                ]
            ]
        );
        return response()->json([
            'status' => 'success',
            'message' => 'Vision and Mission seeded successfully!',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/storage/{path}', function ($path) {
    $filePath = '/tmp/public/' . $path;
    if (file_exists($filePath)) {
        return response()->file($filePath);
    }
    
    $fallbackPath = storage_path('app/public/' . $path);
    if (file_exists($fallbackPath)) {
        return response()->file($fallbackPath);
    }
    
    abort(404);
})->where('path', '.*');
