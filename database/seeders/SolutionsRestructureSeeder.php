<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Service;

/**
 * SolutionsRestructureSeeder
 *
 * Adds 7 new solution categories (per PDF revision) and seeds
 * each with all sub-services as individual Service records.
 * Uses firstOrCreate so existing data is never overwritten.
 */
class SolutionsRestructureSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────
        // 1. Create the 7 new solution categories
        // ─────────────────────────────────────────────
        $catTech = Category::firstOrCreate(
            ['slug' => 'technology'],
            ['name' => 'Technology Solutions', 'type' => 'service']
        );

        $catAI = Category::firstOrCreate(
            ['slug' => 'ai-emerging-technology'],
            ['name' => 'AI & Emerging Technology', 'type' => 'service']
        );

        $catCreative = Category::firstOrCreate(
            ['slug' => 'creative-brand-experience'],
            ['name' => 'Creative & Brand Experience', 'type' => 'service']
        );

        $catMarketing = Category::firstOrCreate(
            ['slug' => 'growth-marketing'],
            ['name' => 'Growth Marketing', 'type' => 'service']
        );

        $catCloud = Category::firstOrCreate(
            ['slug' => 'cloud-cyber-security'],
            ['name' => 'Cloud & Cyber Security', 'type' => 'service']
        );

        $catConsulting = Category::firstOrCreate(
            ['slug' => 'consulting'],
            ['name' => 'Consulting', 'type' => 'service']
        );

        $catTalent = Category::firstOrCreate(
            ['slug' => 'it-talent-workforce'],
            ['name' => 'IT Talent & Workforce', 'type' => 'service']
        );

        // ─────────────────────────────────────────────
        // 2. A. Technology Solutions (8 services)
        // ─────────────────────────────────────────────
        $techServices = [
            [
                'slug'        => 'website-development',
                'name'        => 'Website Development',
                'icon'        => 'code',
                'description' => 'Membangun website modern, cepat, dan scalable menggunakan Next.js, React, dan Laravel sesuai kebutuhan bisnis Anda.',
                'sub_services' => ['Landing Page', 'Company Profile', 'Web Portal', 'Progressive Web App (PWA)', 'SEO-Optimized Website'],
            ],
            [
                'slug'        => 'mobile-app-development',
                'name'        => 'Mobile App Development',
                'icon'        => 'smartphone',
                'description' => 'Pengembangan aplikasi mobile native iOS dan Android berkualitas tinggi dengan user experience terbaik.',
                'sub_services' => ['iOS App (Swift)', 'Android App (Kotlin)', 'Cross-Platform (React Native)', 'Flutter App', 'App Store Optimization'],
            ],
            [
                'slug'        => 'web-application-development',
                'name'        => 'Web Application Development',
                'icon'        => 'layout',
                'description' => 'Membangun web application kompleks dan interaktif mulai dari dashboard internal hingga platform B2B/B2C.',
                'sub_services' => ['SaaS Platform', 'Admin Dashboard', 'CRM System', 'Internal Portal', 'Multi-tenant App'],
            ],
            [
                'slug'        => 'custom-software-development',
                'name'        => 'Custom Software Development',
                'icon'        => 'code',
                'description' => 'Pengembangan perangkat lunak kustom sesuai kebutuhan spesifik bisnis Anda, mulai dari ERP hingga sistem otomasi internal.',
                'sub_services' => ['ERP Development', 'Inventory System', 'POS System', 'Payroll System', 'Custom Automation'],
            ],
            [
                'slug'        => 'government-digital-solutions',
                'name'        => 'Government Digital Solutions',
                'icon'        => 'landmark',
                'description' => 'Solusi digital untuk instansi pemerintah: portal layanan publik, sistem administrasi, dan infrastruktur e-government.',
                'sub_services' => ['Government Portal', 'e-Service Platform', 'Document Management', 'e-Procurement', 'Public Data Dashboard'],
            ],
            [
                'slug'        => 'system-integration',
                'name'        => 'System Integration',
                'icon'        => 'git-merge',
                'description' => 'Mengintegrasikan berbagai sistem dan platform yang berbeda agar dapat berkomunikasi dan bekerja secara mulus.',
                'sub_services' => ['API Development & Integration', 'Third-party Integration', 'Payment Gateway Integration', 'ERP Integration', 'Webhook & Automation'],
            ],
            [
                'slug'        => 'ui-ux-design',
                'name'        => 'UI/UX Design',
                'icon'        => 'figma',
                'description' => 'Merancang antarmuka digital yang indah, intuitif, dan berpusat pada pengguna untuk meningkatkan konversi dan retensi.',
                'sub_services' => ['User Research', 'Wireframing & Prototyping', 'UI Design (Figma)', 'Usability Testing', 'Design System'],
            ],
            [
                'slug'        => 'maintenance-support',
                'name'        => 'Maintenance & Support',
                'icon'        => 'tool',
                'description' => 'Layanan pemeliharaan dan dukungan teknis berkelanjutan untuk memastikan produk digital Anda selalu berjalan optimal.',
                'sub_services' => ['Bug Fixing', 'Performance Monitoring', 'Security Patching', 'Feature Enhancement', '24/7 Technical Support'],
            ],
        ];

        foreach ($techServices as $svc) {
            Service::firstOrCreate(
                ['slug' => $svc['slug']],
                array_merge($svc, ['category_id' => $catTech->id])
            );
        }

        // ─────────────────────────────────────────────
        // 2. B. AI & Emerging Technology (12 services)
        // ─────────────────────────────────────────────
        $aiServices = [
            [
                'slug'        => 'artificial-intelligence',
                'name'        => 'Artificial Intelligence',
                'icon'        => 'cpu',
                'description' => 'Membangun solusi berbasis kecerdasan buatan untuk otomasi, prediksi, dan pengambilan keputusan yang lebih cerdas.',
                'sub_services' => ['AI Strategy Consulting', 'AI Model Development', 'Computer Vision', 'NLP Solutions', 'AI Integration'],
            ],
            [
                'slug'        => 'ai-agent-development',
                'name'        => 'AI Agent Development',
                'icon'        => 'bot',
                'description' => 'Membangun AI agent otonom yang mampu menjalankan tugas kompleks, berinteraksi dengan sistem, dan belajar dari data.',
                'sub_services' => ['Autonomous Agent', 'Multi-agent System', 'Task Automation Agent', 'LLM Fine-tuning', 'RAG Implementation'],
            ],
            [
                'slug'        => 'ai-chatbot',
                'name'        => 'AI Chatbot',
                'icon'        => 'message-square',
                'description' => 'Asisten percakapan berbasis AI untuk customer service, lead generation, dan otomasi komunikasi bisnis Anda.',
                'sub_services' => ['WhatsApp Chatbot', 'Website Chatbot', 'Telegram Bot', 'Custom AI Chatbot', 'Chatbot Analytics'],
            ],
            [
                'slug'        => 'machine-learning',
                'name'        => 'Machine Learning',
                'icon'        => 'trending-up',
                'description' => 'Mengembangkan model machine learning untuk prediksi, klasifikasi, rekomendasi, dan analisis pola dari data bisnis Anda.',
                'sub_services' => ['Predictive Analytics', 'Recommendation Engine', 'Fraud Detection', 'Demand Forecasting', 'ML Model Training'],
            ],
            [
                'slug'        => 'business-intelligence',
                'name'        => 'Business Intelligence',
                'icon'        => 'bar-chart-2',
                'description' => 'Transformasi data mentah menjadi insight bisnis yang actionable melalui dashboard BI dan laporan analitik terintegrasi.',
                'sub_services' => ['BI Dashboard', 'KPI Reporting', 'Data Visualization', 'Executive Dashboard', 'Self-service BI'],
            ],
            [
                'slug'        => 'data-analytics',
                'name'        => 'Data Analytics',
                'icon'        => 'database',
                'description' => 'Menganalisis data bisnis untuk menemukan pola, tren, dan peluang yang dapat mendorong pertumbuhan bisnis Anda.',
                'sub_services' => ['Descriptive Analytics', 'Diagnostic Analytics', 'Predictive Analytics', 'Prescriptive Analytics', 'A/B Testing'],
            ],
            [
                'slug'        => 'data-engineering',
                'name'        => 'Data Engineering',
                'icon'        => 'layers',
                'description' => 'Membangun infrastruktur dan pipeline data yang handal untuk mengelola, memproses, dan menyajikan data skala besar.',
                'sub_services' => ['Data Pipeline', 'Data Warehouse', 'ETL/ELT Process', 'Data Lake', 'Real-time Streaming'],
            ],
            [
                'slug'        => 'iot-development',
                'name'        => 'IoT Development',
                'icon'        => 'wifi',
                'description' => 'Menghubungkan perangkat fisik ke dunia digital melalui solusi IoT yang scalable untuk industri, smart city, dan manufaktur.',
                'sub_services' => ['IoT Platform', 'Sensor Integration', 'Smart Device Dashboard', 'Industrial IoT', 'Edge Computing'],
            ],
            [
                'slug'        => 'ar-vr',
                'name'        => 'AR/VR',
                'icon'        => 'glasses',
                'description' => 'Pengalaman Augmented Reality dan Virtual Reality untuk pelatihan, marketing, simulasi, dan presentasi produk.',
                'sub_services' => ['AR Application', 'VR Experience', 'Mixed Reality', '3D Product Visualization', 'Virtual Showroom'],
            ],
            [
                'slug'        => 'interactive-technology',
                'name'        => 'Interactive Technology',
                'icon'        => 'zap',
                'description' => 'Solusi teknologi interaktif untuk event, instalasi digital, dan pengalaman pengguna yang immersive dan engaging.',
                'sub_services' => ['Interactive Installation', 'Digital Exhibition', 'Touch Interface', 'Motion Sensor', 'Interactive Display'],
            ],
            [
                'slug'        => 'game-development',
                'name'        => 'Game Development',
                'icon'        => 'gamepad-2',
                'description' => 'Pengembangan game 2D/3D untuk mobile, PC, dan web dengan mekanisme gameplay yang engaging dan monetisasi optimal.',
                'sub_services' => ['Mobile Game', 'Browser Game', '2D Game', '3D Game', 'Gamification'],
            ],
            [
                'slug'        => 'automation',
                'name'        => 'Automation',
                'icon'        => 'repeat',
                'description' => 'Otomasi proses bisnis repetitif menggunakan RPA, workflow automation, dan integrasi tool untuk efisiensi maksimal.',
                'sub_services' => ['RPA (Robotic Process Automation)', 'Workflow Automation', 'Marketing Automation', 'DevOps Automation', 'Test Automation'],
            ],
        ];

        foreach ($aiServices as $svc) {
            Service::firstOrCreate(
                ['slug' => $svc['slug']],
                array_merge($svc, ['category_id' => $catAI->id])
            );
        }

        // ─────────────────────────────────────────────
        // 2. C. Creative & Brand Experience (9 services)
        // ─────────────────────────────────────────────
        $creativeServices = [
            [
                'slug'        => 'brand-strategy',
                'name'        => 'Brand Strategy',
                'icon'        => 'target',
                'description' => 'Merancang strategi merek yang komprehensif, dari riset kompetitor hingga positioning yang kuat di pasar target Anda.',
                'sub_services' => ['Brand Audit', 'Brand Positioning', 'Competitor Analysis', 'Target Audience Research', 'Brand Architecture'],
            ],
            [
                'slug'        => 'brand-identity',
                'name'        => 'Brand Identity',
                'icon'        => 'star',
                'description' => 'Membangun identitas merek yang kuat dan konsisten: logo, warna, tipografi, dan panduan merek yang komprehensif.',
                'sub_services' => ['Logo Design', 'Brand Guidelines', 'Color Palette', 'Typography System', 'Brand Stationery'],
            ],
            [
                'slug'        => 'graphic-design',
                'name'        => 'Graphic Design',
                'icon'        => 'pen-tool',
                'description' => 'Desain grafis berkualitas untuk kebutuhan marketing, media sosial, publikasi, dan aset visual bisnis Anda.',
                'sub_services' => ['Social Media Design', 'Print Design', 'Infographic', 'Banner & Display Ads', 'Packaging Design'],
            ],
            [
                'slug'        => 'photography',
                'name'        => 'Photography',
                'icon'        => 'camera',
                'description' => 'Layanan fotografi profesional untuk produk, korporat, event, dan konten digital yang membangun kepercayaan merek.',
                'sub_services' => ['Product Photography', 'Corporate Photography', 'Event Photography', 'Food Photography', 'Lifestyle Photography'],
            ],
            [
                'slug'        => 'videography',
                'name'        => 'Videography',
                'icon'        => 'video',
                'description' => 'Produksi video profesional untuk company profile, iklan, testimonial, dan konten digital yang menggerakkan audiens.',
                'sub_services' => ['Company Profile Video', 'Product Video', 'TVC & Commercial', 'Event Coverage', 'Interview & Documentary'],
            ],
            [
                'slug'        => 'motion-graphics',
                'name'        => 'Motion Graphics',
                'icon'        => 'film',
                'description' => 'Animasi grafis dan motion design untuk explainer video, presentasi, iklan digital, dan konten sosial media.',
                'sub_services' => ['Explainer Video', 'Logo Animation', 'Social Media Animation', 'Presentation Animation', 'Title Sequence'],
            ],
            [
                'slug'        => '2d-3d-animation',
                'name'        => '2D/3D Animation',
                'icon'        => 'box',
                'description' => 'Produksi animasi 2D dan 3D berkualitas tinggi untuk iklan, edukasi, game, dan presentasi produk yang memukau.',
                'sub_services' => ['2D Character Animation', '3D Product Animation', 'Architectural Visualization', 'VFX', 'Animated Short Film'],
            ],
            [
                'slug'        => 'content-creation',
                'name'        => 'Content Creation',
                'icon'        => 'edit-3',
                'description' => 'Pembuatan konten digital kreatif untuk media sosial, blog, newsletter, dan platform digital lainnya.',
                'sub_services' => ['Social Media Content', 'Blog Writing', 'Copywriting', 'Script Writing', 'Email Newsletter'],
            ],
            [
                'slug'        => 'creative-campaign',
                'name'        => 'Creative Campaign',
                'icon'        => 'megaphone',
                'description' => 'Merancang dan mengeksekusi kampanye kreatif terpadu yang memorable dan mendorong engagement audiens target Anda.',
                'sub_services' => ['Campaign Strategy', '360° Campaign', 'Activation Campaign', 'Viral Campaign', 'Launch Campaign'],
            ],
        ];

        foreach ($creativeServices as $svc) {
            Service::firstOrCreate(
                ['slug' => $svc['slug']],
                array_merge($svc, ['category_id' => $catCreative->id])
            );
        }

        // ─────────────────────────────────────────────
        // 2. D. Growth Marketing (13 services)
        // ─────────────────────────────────────────────
        $marketingServices = [
            [
                'slug'        => 'seo',
                'name'        => 'SEO',
                'icon'        => 'search',
                'description' => 'Optimasi mesin pencari yang komprehensif untuk meningkatkan peringkat organik dan mendatangkan traffic berkualitas.',
                'sub_services' => ['Technical SEO', 'On-page SEO', 'Off-page & Link Building', 'Local SEO', 'E-commerce SEO'],
            ],
            [
                'slug'        => 'google-ads',
                'name'        => 'Google Ads',
                'icon'        => 'trending-up',
                'description' => 'Kampanye Google Ads berbasis data untuk mendatangkan lead berkualitas tinggi dengan ROI yang terukur dan optimal.',
                'sub_services' => ['Search Campaign', 'Display Campaign', 'Shopping Ads', 'YouTube Ads', 'Performance Max'],
            ],
            [
                'slug'        => 'meta-ads',
                'name'        => 'Meta Ads',
                'icon'        => 'share-2',
                'description' => 'Pengelolaan iklan Facebook dan Instagram yang strategis untuk menjangkau audiens tepat dan meningkatkan konversi.',
                'sub_services' => ['Facebook Ads', 'Instagram Ads', 'Retargeting', 'Lookalike Audience', 'Catalog Ads'],
            ],
            [
                'slug'        => 'tiktok-ads',
                'name'        => 'TikTok Ads',
                'icon'        => 'music',
                'description' => 'Strategi iklan TikTok yang kreatif untuk menjangkau generasi muda dan meningkatkan brand awareness secara viral.',
                'sub_services' => ['In-Feed Ads', 'TopView Ads', 'Branded Hashtag Challenge', 'Spark Ads', 'TikTok Shop Ads'],
            ],
            [
                'slug'        => 'linkedin-ads',
                'name'        => 'LinkedIn Ads',
                'icon'        => 'briefcase',
                'description' => 'Iklan LinkedIn yang ditargetkan untuk B2B lead generation, employer branding, dan menjangkau profesional industri.',
                'sub_services' => ['Sponsored Content', 'Lead Gen Forms', 'InMail Campaign', 'Company Page Ads', 'B2B Retargeting'],
            ],
            [
                'slug'        => 'marketplace-management',
                'name'        => 'Marketplace Management',
                'icon'        => 'shopping-bag',
                'description' => 'Pengelolaan toko di berbagai marketplace (Tokopedia, Shopee, Lazada) untuk memaksimalkan penjualan dan visibilitas produk.',
                'sub_services' => ['Store Setup & Optimization', 'Product Listing', 'Marketplace SEO', 'Order Management', 'Rating Management'],
            ],
            [
                'slug'        => 'marketplace-ads',
                'name'        => 'Marketplace Ads',
                'icon'        => 'tag',
                'description' => 'Pengelolaan iklan berbayar di marketplace untuk meningkatkan visibilitas produk dan mendorong penjualan secara signifikan.',
                'sub_services' => ['Tokopedia Ads', 'Shopee Ads', 'Lazada Ads', 'Temu Ads', 'ROI-based Optimization'],
            ],
            [
                'slug'        => 'social-media-management',
                'name'        => 'Social Media Management',
                'icon'        => 'instagram',
                'description' => 'Pengelolaan akun media sosial secara menyeluruh untuk membangun komunitas, engagement, dan brand awareness yang konsisten.',
                'sub_services' => ['Content Planning', 'Community Management', 'Story & Reels', 'Social Listening', 'Monthly Reporting'],
            ],
            [
                'slug'        => 'content-marketing',
                'name'        => 'Content Marketing',
                'icon'        => 'file-text',
                'description' => 'Strategi dan produksi konten yang bernilai untuk menarik, mengedukasi, dan mengkonversi audiens target Anda.',
                'sub_services' => ['Blog Strategy', 'SEO Article Writing', 'Lead Magnet', 'Case Study', 'Whitepaper'],
            ],
            [
                'slug'        => 'influencer-marketing',
                'name'        => 'Influencer Marketing',
                'icon'        => 'users',
                'description' => 'Kolaborasi dengan influencer yang relevan untuk memperluas jangkauan merek dan mendorong kepercayaan konsumen.',
                'sub_services' => ['Influencer Sourcing', 'Campaign Management', 'KOL Strategy', 'Micro-influencer', 'Performance Tracking'],
            ],
            [
                'slug'        => 'email-marketing',
                'name'        => 'Email Marketing',
                'icon'        => 'mail',
                'description' => 'Strategi email marketing yang personal dan terautomasi untuk nurturing lead, retensi pelanggan, dan upselling.',
                'sub_services' => ['Email Strategy', 'Newsletter Design', 'Drip Campaign', 'Email Automation', 'A/B Testing'],
            ],
            [
                'slug'        => 'live-commerce',
                'name'        => 'Live Commerce',
                'icon'        => 'radio',
                'description' => 'Solusi live selling yang interaktif di TikTok Shop, Shopee Live, dan platform lainnya untuk mendorong konversi real-time.',
                'sub_services' => ['Live Strategy', 'Host & Talent', 'Live Production', 'Product Highlight', 'Post-live Analysis'],
            ],
            [
                'slug'        => 'conversion-optimization',
                'name'        => 'Conversion Optimization',
                'icon'        => 'percent',
                'description' => 'Mengoptimalkan funnel konversi website dan landing page untuk meningkatkan persentase pengunjung yang menjadi pelanggan.',
                'sub_services' => ['CRO Audit', 'Landing Page Optimization', 'A/B Testing', 'Heatmap Analysis', 'Funnel Optimization'],
            ],
        ];

        foreach ($marketingServices as $svc) {
            Service::firstOrCreate(
                ['slug' => $svc['slug']],
                array_merge($svc, ['category_id' => $catMarketing->id])
            );
        }

        // ─────────────────────────────────────────────
        // 2. E. Cloud & Cyber Security (8 services)
        // ─────────────────────────────────────────────
        $cloudServices = [
            [
                'slug'        => 'cloud-services',
                'name'        => 'Cloud Services',
                'icon'        => 'cloud',
                'description' => 'Layanan cloud komprehensif di AWS, GCP, dan Azure untuk membangun infrastruktur yang scalable, reliable, dan efisien.',
                'sub_services' => ['AWS', 'Google Cloud', 'Microsoft Azure', 'Cloud Architecture', 'Cost Optimization'],
            ],
            [
                'slug'        => 'cloud-migration',
                'name'        => 'Cloud Migration',
                'icon'        => 'upload-cloud',
                'description' => 'Migrasi infrastruktur dan aplikasi on-premise ke cloud secara aman, efisien, dan tanpa downtime yang berarti.',
                'sub_services' => ['Migration Assessment', 'Lift & Shift', 'Re-platform', 'Re-architect', 'Post-migration Support'],
            ],
            [
                'slug'        => 'devops',
                'name'        => 'DevOps',
                'icon'        => 'git-branch',
                'description' => 'Implementasi praktik DevOps modern untuk mempercepat delivery, meningkatkan kualitas, dan mengotomasi pipeline deployment.',
                'sub_services' => ['CI/CD Pipeline', 'Containerization (Docker)', 'Kubernetes Orchestration', 'IaC (Terraform)', 'Monitoring & Alerting'],
            ],
            [
                'slug'        => 'infrastructure',
                'name'        => 'Infrastructure',
                'icon'        => 'server',
                'description' => 'Perancangan dan pengelolaan infrastruktur IT yang robust, scalable, dan high-availability untuk bisnis Anda.',
                'sub_services' => ['Server Management', 'Network Architecture', 'Load Balancing', 'CDN Setup', 'Backup & DR'],
            ],
            [
                'slug'        => 'cyber-security',
                'name'        => 'Cyber Security',
                'icon'        => 'shield',
                'description' => 'Perlindungan aset digital bisnis Anda dari ancaman siber melalui strategi keamanan berlapis yang komprehensif.',
                'sub_services' => ['Security Strategy', 'Firewall Management', 'Endpoint Security', 'Incident Response', 'SOC as a Service'],
            ],
            [
                'slug'        => 'security-assessment',
                'name'        => 'Security Assessment',
                'icon'        => 'shield-check',
                'description' => 'Penilaian keamanan menyeluruh untuk mengidentifikasi kerentanan sistem sebelum dieksploitasi oleh pihak yang tidak bertanggung jawab.',
                'sub_services' => ['Penetration Testing', 'Vulnerability Assessment', 'VAPT', 'Code Review', 'Compliance Audit'],
            ],
            [
                'slug'        => 'quality-assurance',
                'name'        => 'Quality Assurance',
                'icon'        => 'check-circle',
                'description' => 'Pengujian kualitas software yang komprehensif untuk memastikan produk digital Anda bebas bug dan siap dirilis.',
                'sub_services' => ['Manual Testing', 'Automated Testing', 'Performance Testing', 'Load Testing', 'Regression Testing'],
            ],
            [
                'slug'        => 'managed-services',
                'name'        => 'Managed Services',
                'icon'        => 'settings',
                'description' => 'Pengelolaan dan pemantauan infrastruktur IT secara proaktif oleh tim ahli Diggity, sehingga Anda bisa fokus pada bisnis inti.',
                'sub_services' => ['24/7 Monitoring', 'Patch Management', 'Performance Tuning', 'Capacity Planning', 'SLA-based Support'],
            ],
        ];

        foreach ($cloudServices as $svc) {
            Service::firstOrCreate(
                ['slug' => $svc['slug']],
                array_merge($svc, ['category_id' => $catCloud->id])
            );
        }

        // ─────────────────────────────────────────────
        // 2. F. Consulting (4 services)
        // ─────────────────────────────────────────────
        $consultingServices = [
            [
                'slug'        => 'it-consulting',
                'name'        => 'IT Consulting',
                'icon'        => 'help-circle',
                'description' => 'Konsultasi teknologi informasi strategis untuk membantu bisnis Anda memilih, mengimplementasikan, dan mengoptimalkan solusi IT.',
                'sub_services' => ['IT Strategy', 'Technology Assessment', 'Vendor Selection', 'IT Roadmap', 'Digital Architecture'],
            ],
            [
                'slug'        => 'business-consulting',
                'name'        => 'Business Consulting',
                'icon'        => 'briefcase',
                'description' => 'Konsultasi bisnis untuk mengidentifikasi peluang pertumbuhan, mengoptimalkan proses, dan meningkatkan profitabilitas.',
                'sub_services' => ['Business Analysis', 'Process Optimization', 'Growth Strategy', 'Market Entry', 'Business Model Innovation'],
            ],
            [
                'slug'        => 'digital-transformation',
                'name'        => 'Digital Transformation',
                'icon'        => 'refresh-cw',
                'description' => 'Pendampingan transformasi digital end-to-end: dari penilaian kesiapan organisasi hingga implementasi dan change management.',
                'sub_services' => ['Digital Readiness Assessment', 'Transformation Roadmap', 'Change Management', 'Digital Culture', 'Innovation Workshop'],
            ],
            [
                'slug'        => 'technology-advisory',
                'name'        => 'Technology Advisory',
                'icon'        => 'compass',
                'description' => 'Layanan advisory teknologi untuk eksekutif dan board level dalam pengambilan keputusan teknologi strategis.',
                'sub_services' => ['CTO Advisory', 'Technology Due Diligence', 'Tech Stack Review', 'Innovation Advisory', 'Emerging Tech Briefing'],
            ],
        ];

        foreach ($consultingServices as $svc) {
            Service::firstOrCreate(
                ['slug' => $svc['slug']],
                array_merge($svc, ['category_id' => $catConsulting->id])
            );
        }

        // ─────────────────────────────────────────────
        // 2. G. IT Talent & Workforce (2 services)
        //    These already exist in TalentService table,
        //    but we add them as Service records too
        //    for consistent navigation routing.
        // ─────────────────────────────────────────────
        $talentServices = [
            [
                'slug'        => 'it-headhunting',
                'name'        => 'IT Headhunting',
                'icon'        => 'user-check',
                'description' => 'Kami membantu perusahaan menjaring, menyaring, dan merekrut talenta digital teratas dengan kualifikasi teknis presisi.',
                'sub_services' => ['Technical Talent Search', 'Candidate Screening', 'Interview Process', 'Placement Guarantee', '90-Day Replacement Warranty'],
            ],
            [
                'slug'        => 'it-outsourcing',
                'name'        => 'IT Outsourcing',
                'icon'        => 'users',
                'description' => 'Penyediaan tim pengembang lengkap yang dikelola penuh oleh Diggity untuk membangun produk digital Anda.',
                'sub_services' => ['Dedicated Developer', 'Full Development Squad', 'Project-based Team', 'Agile Team Setup', 'Managed IT Team'],
            ],
        ];

        foreach ($talentServices as $svc) {
            Service::firstOrCreate(
                ['slug' => $svc['slug']],
                array_merge($svc, ['category_id' => $catTalent->id])
            );
        }

        $this->command->info('✅ SolutionsRestructureSeeder: 7 categories + 56 services seeded successfully!');
    }
}
