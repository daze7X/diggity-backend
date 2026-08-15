<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Blog;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\CompanySetting;
use App\Models\Career;
use App\Models\Product;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\TalentProfile;
use App\Models\User;

class DiggitySeeder extends Seeder
{
    public function run(): void
    {
        // 0. Super Admin & Demo Users
        User::updateOrCreate(
            ['email' => 'superadmin@diggity.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin1234'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@diggity.com'],
            [
                'name' => 'Admin Biasa',
                'password' => bcrypt('admin1234'),
                'role' => 'admin',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Budi Setiawan',
                'password' => bcrypt('password'),
                'role' => 'customer',
            ]
        );

        // 1. Company Settings
        CompanySetting::updateOrCreate(
            ['email' => 'hello@diggity.com'],
            [
                'name' => 'Diggity Agency',
                'whatsapp' => '628123456789',
                'address' => 'Gedung Digital Hub, Lt. 5, Jl. Technopark No. 12, BSD City, Tangerang',
                'instagram_url' => 'https://instagram.com/diggity.agency',
                'linkedin_url' => 'https://linkedin.com/company/diggity-agency'
            ]
        );

        // 2. Categories for Services (type: service)
        $catApp = Category::updateOrCreate(['name' => 'App Builder Squad'], ['slug' => 'app-builder-squad', 'type' => 'service']);
        $catBrand = Category::updateOrCreate(['name' => 'Brand Growth Division'], ['slug' => 'brand-growth-division', 'type' => 'service']);
        $catCloud = Category::updateOrCreate(['name' => 'Cloud Service Hub'], ['slug' => 'cloud-service-hub', 'type' => 'service']);
        $catLab = Category::updateOrCreate(['name' => 'Digital Skill Lab'], ['slug' => 'digital-skill-lab', 'type' => 'service']);
        $catTalent = Category::updateOrCreate(['name' => 'Tech Talent Solutions'], ['slug' => 'tech-talent-solutions', 'type' => 'service']);

        // 2.1 Categories for Blogs/Insights (type: blog)
        $catTechBlog = Category::updateOrCreate(['name' => 'Technology Insights'], ['slug' => 'technology-insights', 'type' => 'blog']);
        $catMarketingBlog = Category::updateOrCreate(['name' => 'Marketing Trends'], ['slug' => 'marketing-trends', 'type' => 'blog']);
        $catCloudBlog = Category::updateOrCreate(['name' => 'Cloud & Security'], ['slug' => 'cloud-security', 'type' => 'blog']);
        $catNews = Category::updateOrCreate(['name' => 'Berita & Pengumuman'], ['slug' => 'news-announcements', 'type' => 'blog']);

        // 2.2 Categories for Products (type: product)
        $catSoftware = Category::updateOrCreate(['name' => 'Business Software'], ['slug' => 'business-software', 'type' => 'product']);
        $catAIProducts = Category::updateOrCreate(['name' => 'AI Products'], ['slug' => 'ai-products', 'type' => 'product']);
        $catCloudProducts = Category::updateOrCreate(['name' => 'Cloud Products'], ['slug' => 'cloud-products', 'type' => 'product']);
        $catMarketplace = Category::updateOrCreate(['name' => 'Digital Marketplace'], ['slug' => 'digital-marketplace', 'type' => 'product']);

        // 2.3 Categories for Academy (type: academy)
        $catBootcamp = Category::updateOrCreate(['name' => 'Bootcamp'], ['slug' => 'bootcamp', 'type' => 'academy']);
        $catWebinar = Category::updateOrCreate(['name' => 'Webinar & Workshop'], ['slug' => 'webinar-workshop', 'type' => 'academy']);

        // 3. Services (Solutions)
        Service::updateOrCreate(
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

        Service::updateOrCreate(
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

        Service::updateOrCreate(
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

        Service::updateOrCreate(
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

        Service::updateOrCreate(
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

        Service::updateOrCreate(
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

        Service::updateOrCreate(
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

        Service::updateOrCreate(
            ['slug' => 'headhunting'],
            [
                'category_id' => $catTalent->id,
                'name' => 'IT Headhunting',
                'description' => 'Hire the best tech talent quickly based on your needs.',
                'icon' => 'user-check'
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'outsourcing'],
            [
                'category_id' => $catTalent->id,
                'name' => 'IT Outsourcing',
                'description' => 'Build a remote developer team in 7 days.',
                'icon' => 'users'
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'job-connect'],
            [
                'category_id' => $catTalent->id,
                'name' => 'Job Connect',
                'description' => 'Connecting certified digital talents with companies.',
                'icon' => 'briefcase'
            ]
        );

        // 4. Products (Ready-to-use digital products)
        Product::updateOrCreate(
            ['slug' => 'diggity-erp'],
            [
                'category_id' => $catSoftware->id,
                'name' => 'Diggity ERP',
                'sku' => 'DG-ERP-01',
                'price' => 15000000.00,
                'billing_period' => 'yearly',
                'description' => 'Sistem ERP lengkap untuk manajemen inventori, keuangan, penggajian karyawan, dan absensi.',
                'features' => ['Modul Akuntansi & Keuangan', 'Manajemen Inventori & Gudang', 'Penggajian (Payroll) & HR', 'Laporan Real-time'],
                'gallery' => ['products/erp-dashboard.jpg', 'products/erp-inventory.jpg'],
                'license_info' => 'Lisensi tahunan untuk 1 server perusahaan.',
                'version' => '1.2.0',
                'is_active' => true,
                'is_popular' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'diggity-ai-agent'],
            [
                'category_id' => $catAIProducts->id,
                'name' => 'Diggity AI Agent',
                'sku' => 'DG-AI-AG',
                'price' => 2500000.00,
                'billing_period' => 'monthly',
                'description' => 'Asisten pintar kecerdasan buatan untuk mengotomatisasi percakapan customer service dan lead generation.',
                'features' => ['Integrasi WhatsApp & Telegram', 'Custom AI Training Data', 'Dashboard Analitik Chat', 'Multi-agent Handoff'],
                'gallery' => ['products/ai-dashboard.jpg'],
                'license_info' => 'Langganan bulanan per chatbot aktif.',
                'version' => '1.0.5',
                'is_active' => true,
                'is_popular' => false,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'sleek-dashboard-ui-kit'],
            [
                'category_id' => $catMarketplace->id,
                'name' => 'Sleek Dashboard UI Kit',
                'sku' => 'DG-SLK-UI',
                'price' => 450000.00,
                'billing_period' => 'one_time',
                'description' => 'Desain dashboard premium siap pakai dengan Figma file dan React component lengkap.',
                'features' => ['100+ UI Components', 'Figma & React Code Terintegrasi', 'Dukungan Mode Gelap & Terang', 'Pembaruan Gratis Selamanya'],
                'gallery' => ['products/sleek-preview.jpg'],
                'license_info' => 'Lisensi personal/komersial satu kali bayar.',
                'version' => '2.0.0',
                'file_path' => 'products/sleek-dashboard-ui-kit.zip',
                'is_active' => true,
                'is_popular' => true,
            ]
        );

        // 5. Courses (Academy)
        $course1 = Course::updateOrCreate(
            ['slug' => 'fullstack-laravel-nextjs-bootcamp'],
            [
                'category_id' => $catBootcamp->id,
                'title' => 'Fullstack Laravel & Next.js Bootcamp',
                'description' => 'Pelatihan intensif 12 minggu untuk menguasai pembuatan aplikasi web skala industri dengan backend API Laravel 12 dan frontend Next.js 16.',
                'syllabus' => 'Minggu 1-3: RESTful API Laravel & PostgreSQL; Minggu 4-6: Next.js App Router & Server Actions; Minggu 7-9: JWT Authentication & State Management; Minggu 10-12: Project Akhir & Deployment VPS.',
                'instructor_name' => 'Budi Pratama',
                'instructor_title' => 'Senior Fullstack Engineer',
                'price' => 3500000.00,
                'is_active' => true,
                'is_featured' => true,
                'image' => 'courses/laravel-nextjs-bootcamp.jpg'
            ]
        );

        // Seed Course Modules
        $module1 = Module::updateOrCreate(
            ['course_id' => $course1->id, 'title' => 'Introduction to Laravel API'],
            ['description' => 'Belajar dasar rekayasa API, routing, controller, dan migrations di Laravel.', 'sort_order' => 1]
        );
        $module2 = Module::updateOrCreate(
            ['course_id' => $course1->id, 'title' => 'Next.js Frontend Integration'],
            ['description' => 'Menghubungkan aplikasi frontend Next.js dengan API Laravel.', 'sort_order' => 2]
        );

        // Seed Lessons
        Lesson::updateOrCreate(
            ['module_id' => $module1->id, 'slug' => 'routing-dan-controller-api'],
            [
                'title' => 'Routing dan Controller API di Laravel',
                'content_type' => 'video',
                'content' => 'Dalam video ini kita akan belajar bagaimana mendefinisikan route API dan menghubungkannya dengan controller.',
                'video_url' => 'https://player.vimeo.com/video/123456789',
                'duration_minutes' => 15,
                'sort_order' => 1
            ]
        );
        Lesson::updateOrCreate(
            ['module_id' => $module1->id, 'slug' => 'eloquent-orm-dan-database-seeding'],
            [
                'title' => 'Eloquent ORM dan Database Seeding',
                'content_type' => 'article',
                'content' => 'Eloquent ORM adalah fitur canggih Laravel untuk manipulasi database menggunakan paradigma pemrograman berorientasi objek (OOP).',
                'video_url' => null,
                'duration_minutes' => 10,
                'sort_order' => 2
            ]
        );
        Lesson::updateOrCreate(
            ['module_id' => $module2->id, 'slug' => 'fetching-data-pada-nextjs'],
            [
                'title' => 'Fetching Data pada Next.js (SSR & ISR)',
                'content_type' => 'video',
                'content' => 'Belajar cara mengambil data dari API Laravel menggunakan fetch pada Server Components Next.js.',
                'video_url' => 'https://player.vimeo.com/video/987654321',
                'duration_minutes' => 20,
                'sort_order' => 1
            ]
        );

        // 6. Portfolios
        Portfolio::updateOrCreate(
            ['slug' => 'sistem-informasi-logistik-nasional'],
            [
                'category_id' => $catApp->id,
                'title' => 'Sistem Informasi Logistik Nasional',
                'client' => 'PT Transindo Logistik',
                'duration' => '4 Bulan',
                'technologies' => ['Laravel', 'PostgreSQL', 'Tailwind CSS', 'Vue.js'],
                'problem' => 'Klien memiliki sistem pelacakan armada manual yang lambat dan sering memicu salah komunikasi dengan kurir pengirim barang.',
                'strategy' => 'Merancang platform ERP logistik terintegrasi dengan pelacakan GPS real-time dan dashboard performa pengiriman.',
                'execution' => 'Membangun arsitektur backend Laravel yang tangguh dengan database PostgreSQL terindeks, dipadukan dengan SPA Vue.js.',
                'result' => 'Waktu koordinasi pengiriman terpangkas sebesar 65% dan efisiensi rute armada meningkat 30%.',
                'solution' => 'ERP Logistik Terintegrasi Real-time.',
                'image' => 'portfolios/logistik-nasional.jpg'
            ]
        );

        Portfolio::updateOrCreate(
            ['slug' => 'kampanye-growth-marketing-e-commerce'],
            [
                'category_id' => $catBrand->id,
                'title' => 'Kampanye Growth Marketing E-Commerce Fashion',
                'client' => 'Luxura Wear',
                'duration' => '3 Bulan',
                'technologies' => ['Meta Ads', 'Google Analytics 4', 'SEO', 'TikTok Ads'],
                'problem' => 'Tingkat konversi e-commerce Luxura Wear sangat rendah (dibawah 0.8%) dan biaya akuisisi pelanggan (CAC) terlampau tinggi.',
                'strategy' => 'Melakukan audit corong konversi, memperketat audiens target di Meta Ads, dan mengoptimalkan retargeting dinamis.',
                'execution' => 'Menyusun materi iklan video estetik, memasang pixel pelacakan konversi presisi tinggi, dan optimasi landing page.',
                'result' => 'Tingkat konversi melonjak menjadi 2.8% dan ROAS (Return on Ad Spend) rata-rata mencapai 4.2x.',
                'solution' => 'Corong Konversi & Retargeting Dinamis.',
                'image' => 'portfolios/growth-marketing.jpg'
            ]
        );

        Portfolio::updateOrCreate(
            ['slug' => 'migrasi-cloud-infrastruktur-keamanan-tinggi'],
            [
                'category_id' => $catCloud->id,
                'title' => 'Infrastruktur Multi-Cloud & Auto-Scaling',
                'client' => 'PT Global Finance Indonesia',
                'duration' => '2 Bulan',
                'technologies' => ['AWS', 'Docker', 'Kubernetes', 'Nginx', 'Cloudflare'],
                'problem' => 'Server keuangan sering mengalami mati total (down) saat jam sibuk transaksi bulanan karena lonjakan beban server.',
                'strategy' => 'Merancang arsitektur server dengan konsep auto-scaling dan sistem load balancing multi-region AWS.',
                'execution' => 'Kontainerisasi aplikasi dengan Docker, deployment Kubernetes cluster, serta implementasi proteksi DDoS Cloudflare.',
                'result' => 'Uptime server mencapai 99.99% dan kecepatan respon sistem meningkat 45% lebih cepat.',
                'solution' => 'Arsitektur High-Availability Multi-Cloud.',
                'image' => 'portfolios/multi-cloud.jpg'
            ]
        );

        // 7. Blogs (Insights)
        Blog::updateOrCreate(
            ['slug' => '5-teknologi-web-modern-terbaik-2026'],
            [
                'category_id' => $catTechBlog->id,
                'title' => '5 Teknologi Web Modern Terbaik di Tahun 2026',
                'content' => '<p>Dunia pengembangan web bergerak sangat cepat. Di tahun 2026 ini, beberapa teknologi telah dominasi industri karena kemampuannya memberikan performa maksimal dan efisiensi kode.</p><h3>1. Next.js 16</h3><p>Dengan peningkatan kecepatan compile dan dukungan server actions yang lebih matang, Next.js tetap menjadi andalan utama.</p><h3>2. Tailwind CSS v4</h3><p>Tailwind v4 menghadirkan mesin kompilasi baru yang jauh lebih ringan dan cepat.</p>',
                'meta_title' => '5 Teknologi Web Modern Terbaik 2026 | Diggity Blog',
                'meta_description' => 'Pelajari 5 teknologi web development modern terbaik di tahun 2026 yang wajib diadopsi agensi dan bisnis digital untuk meningkatkan kecepatan website.',
                'image' => 'blogs/web-tech-2026.jpg'
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'panduan-seo-pemula-ranking-satu-google'],
            [
                'category_id' => $catMarketingBlog->id,
                'title' => 'Panduan SEO Pemula untuk Menembus Peringkat 1 Google',
                'content' => '<p>SEO (Search Engine Optimization) bukan lagi sekadar menaruh kata kunci di artikel. Google kini menilai pengalaman pengguna, kecepatan website, dan otoritas topik secara menyeluruh.</p>',
                'meta_title' => 'Panduan Lengkap SEO Pemula 2026 | Diggity Blog',
                'meta_description' => 'Pelajari strategi SEO dasar terbaik untuk pemula agar website Anda mendapat peringkat pertama di halaman pencarian Google secara organik.',
                'image' => 'blogs/seo-guide.jpg'
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'cara-migrasi-server-ke-vps-tanpa-downtime'],
            [
                'category_id' => $catCloudBlog->id,
                'title' => 'Cara Migrasi Server ke VPS Cloud Tanpa Downtime',
                'content' => '<p>Migrasi server seringkali menjadi momok karena risiko kehilangan data dan downtime transaksi. Namun, dengan langkah yang tepat, Anda bisa melakukannya secara mulus.</p>',
                'meta_title' => 'Cara Migrasi Server ke VPS Cloud Tanpa Downtime | Diggity Blog',
                'meta_description' => 'Panduan langkah demi langkah memigrasikan database dan file server Anda ke cloud VPS hosting secara aman tanpa mengalami offline.',
                'image' => 'blogs/server-migration.jpg'
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'diggity-ekspansi-layanan-rekayasa-kecerdasan-buatan-lokal'],
            [
                'category_id' => $catNews->id,
                'title' => 'Diggity Resmi Meluncurkan Unit Layanan Rekayasa Kecerdasan Buatan (AI) B2B',
                'content' => '<p>Sebagai bagian dari komitmen mendukung transformasi teknologi korporasi, Diggity secara resmi memperkenalkan unit layanan AI &amp; Emerging Tech untuk membantu integrasi asisten cerdas bagi operasional perusahaan.</p>',
                'meta_title' => 'Diggity Luncurkan Unit AI &amp; Emerging Tech | Diggity News',
                'meta_description' => 'Rilis resmi pengumuman ekspansi unit layanan AI &amp; Emerging Tech terintegrasi Diggity untuk solusi B2B.',
                'image' => 'blogs/web-tech-2026.jpg'
            ]
        );

        // 8. Teams
        Team::updateOrCreate(
            ['name' => 'Ahmad Fauzi'],
            [
                'position' => 'Chief Executive Officer',
                'photo' => null
            ]
        );
        Team::updateOrCreate(
            ['name' => 'Sarah Wijaya'],
            [
                'position' => 'Lead UI/UX Designer',
                'photo' => null
            ]
        );
        Team::updateOrCreate(
            ['name' => 'Budi Pratama'],
            [
                'position' => 'Senior Fullstack Engineer',
                'photo' => null
            ]
        );

        // 9. Testimonials
        Testimonial::updateOrCreate(
            ['client_name' => 'Hendra Wijaya'],
            [
                'company' => 'PT Transindo Logistik',
                'review' => 'Diggity berhasil merevolusi sistem internal kami. Hasil aplikasi mobile mereka sangat cepat, intuitif, dan disukai tim kurir kami.',
                'rating' => 5,
                'avatar' => null
            ]
        );
        Testimonial::updateOrCreate(
            ['client_name' => 'Rina Amalia'],
            [
                'company' => 'Luxura Wear',
                'review' => 'Layanan Ads dan SEO dari Diggity membantu bisnis e-commerce kami tumbuh 3x lipat dalam waktu kurang dari 4 bulan. Hasilnya sangat terukur!',
                'rating' => 5,
                'avatar' => null
            ]
        );

        // 10. FAQs
        Faq::updateOrCreate(
            ['question' => 'Teknologi apa saja yang digunakan oleh Diggity?'],
            [
                'answer' => 'Kami menggunakan stack teknologi modern terbaik seperti Next.js, React, TypeScript, Tailwind CSS untuk frontend, serta Laravel, Node.js, dan PostgreSQL/MySQL untuk backend.'
            ]
        );

        // 11. Careers (Job Connect Vacancies)
        Career::updateOrCreate(
            ['slug' => 'senior-fullstack-developer-laravel-nextjs'],
            [
                'title' => 'Senior Fullstack Developer (Laravel & Next.js)',
                'department' => 'App Builder Squad',
                'type' => 'Full-time',
                'location' => 'BSD City, Tangerang (Hybrid)',
                'description' => '<p>Kami mencari Senior Fullstack Developer berpengalaman untuk merancang, membangun, dan memelihara aplikasi web berskala enterprise menggunakan Laravel 12 dan Next.js 16.</p>',
                'requirements' => '<ul><li>Pengalaman kerja minimal 3 tahun sebagai Fullstack Web Developer.</li><li>Menguasai Laravel, PHP, Next.js, React, TypeScript, dan SQL database.</li><li>Memahami manajemen server VPS, Git, dan integrasi API pihak ketiga.</li></ul>',
                'is_active' => true
            ]
        );

        // 12. Talent Profiles (Job Connect Submissions)
        TalentProfile::updateOrCreate(
            ['email' => 'rian.hidayat@example.com'],
            [
                'name' => 'Rian Hidayat',
                'phone' => '628999888777',
                'type' => 'individual',
                'skills' => ['DevOps', 'AWS', 'Docker', 'Kubernetes', 'CI/CD'],
                'portfolio_links' => ['https://github.com/rianhidayat', 'https://linkedin.com/in/rianhidayat'],
                'resume_path' => 'resumes/rian-resume.pdf',
                'experience_years' => 4,
                'description' => 'Professional DevOps engineer specializing in high-availability AWS infrastructures and Docker orchestration.',
                'status' => 'reviewed'
            ]
        );
    }
}
