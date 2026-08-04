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
        $admin = User::updateOrCreate(
            ['email' => 'admin@diggity.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'super_admin',
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

        // 2.1 Categories for Blogs/Insights (type: blog)
        $catTechBlog = Category::updateOrCreate(['name' => 'Technology Insights'], ['slug' => 'technology-insights', 'type' => 'blog']);
        $catMarketingBlog = Category::updateOrCreate(['name' => 'Marketing Trends'], ['slug' => 'marketing-trends', 'type' => 'blog']);
        $catCloudBlog = Category::updateOrCreate(['name' => 'Cloud & Security'], ['slug' => 'cloud-security', 'type' => 'blog']);

        // 2.2 Categories for Products (type: product)
        $catSoftware = Category::updateOrCreate(['name' => 'Business Software'], ['slug' => 'business-software', 'type' => 'product']);
        $catAIProducts = Category::updateOrCreate(['name' => 'AI Products'], ['slug' => 'ai-products', 'type' => 'product']);
        $catCloudProducts = Category::updateOrCreate(['name' => 'Cloud Products'], ['slug' => 'cloud-products', 'type' => 'product']);
        $catMarketplace = Category::updateOrCreate(['name' => 'Digital Marketplace'], ['slug' => 'digital-marketplace', 'type' => 'product']);

        // 2.3 Categories for Academy (type: academy)
        $catBootcamp = Category::updateOrCreate(['name' => 'Bootcamp'], ['slug' => 'bootcamp', 'type' => 'academy']);
        $catWebinar = Category::updateOrCreate(['name' => 'Webinar & Workshop'], ['slug' => 'webinar-workshop', 'type' => 'academy']);

        // 3. Services (Solutions)
        // App Builder Squad
        Service::updateOrCreate(
            ['slug' => 'website-development'],
            [
                'category_id' => $catApp->id,
                'name' => 'Website Development',
                'description' => 'Membangun website modern berkecepatan tinggi menggunakan teknologi Next.js, Laravel, dan Tailwind CSS.',
                'icon' => 'code'
            ]
        );
        Service::updateOrCreate(
            ['slug' => 'mobile-apps-development'],
            [
                'category_id' => $catApp->id,
                'name' => 'Mobile Apps Development',
                'description' => 'Aplikasi mobile Android dan iOS yang responsif dan berkinerja tinggi menggunakan Flutter dan React Native.',
                'icon' => 'smartphone'
            ]
        );
        Service::updateOrCreate(
            ['slug' => 'ui-ux-design'],
            [
                'category_id' => $catApp->id,
                'name' => 'UI/UX Design',
                'description' => 'Perancangan antarmuka pengguna (UI) dan pengalaman pengguna (UX) yang estetik, intuitif, dan ramah pengguna.',
                'icon' => 'palette'
            ]
        );

        // Brand Growth Division
        Service::updateOrCreate(
            ['slug' => 'search-engine-optimization'],
            [
                'category_id' => $catBrand->id,
                'name' => 'Search Engine Optimization (SEO)',
                'description' => 'Optimasi mesin pencari organik untuk meningkatkan peringkat website Anda di Google secara berkelanjutan.',
                'icon' => 'search'
            ]
        );
        Service::updateOrCreate(
            ['slug' => 'digital-advertising'],
            [
                'category_id' => $catBrand->id,
                'name' => 'Digital Advertising (Ads)',
                'description' => 'Kampanye iklan berbayar bertarget melalui Google Ads dan Meta Ads (Facebook & Instagram) untuk instan leads.',
                'icon' => 'trending-up'
            ]
        );

        // Cloud Service Hub
        Service::updateOrCreate(
            ['slug' => 'cloud-server-hosting'],
            [
                'category_id' => $catCloud->id,
                'name' => 'Cloud Server & VPS Hosting',
                'description' => 'Penyediaan server cloud performa tinggi, setup VPS, manajemen domain, serta email bisnis berkapasitas besar.',
                'icon' => 'server'
            ]
        );

        // Digital Skill Lab (Service)
        Service::updateOrCreate(
            ['slug' => 'corporate-training-bootcamp'],
            [
                'category_id' => $catLab->id,
                'name' => 'Corporate Training & Bootcamp',
                'description' => 'Pelatihan keahlian digital intensif untuk tim korporat dalam bidang IT, UI/UX, dan Digital Marketing.',
                'icon' => 'graduation-cap'
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
