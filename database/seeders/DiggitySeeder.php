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
use App\Models\Pricing;
use App\Models\CompanySetting;
use App\Models\Career;

class DiggitySeeder extends Seeder
{
    public function run(): void
    {
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

        // 2. Categories
        $catApp = Category::updateOrCreate(['name' => 'App Builder Squad'], ['slug' => 'app-builder-squad']);
        $catBrand = Category::updateOrCreate(['name' => 'Brand Growth Division'], ['slug' => 'brand-growth-division']);
        $catCloud = Category::updateOrCreate(['name' => 'Cloud Service Hub'], ['slug' => 'cloud-service-hub']);
        $catLab = Category::updateOrCreate(['name' => 'Digital Skill Lab'], ['slug' => 'digital-skill-lab']);

        // 3. Services
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

        // Digital Skill Lab
        Service::updateOrCreate(
            ['slug' => 'corporate-training-bootcamp'],
            [
                'category_id' => $catLab->id,
                'name' => 'Corporate Training & Bootcamp',
                'description' => 'Pelatihan keahlian digital intensif untuk tim korporat dalam bidang IT, UI/UX, dan Digital Marketing.',
                'icon' => 'graduation-cap'
            ]
        );

        // 4. Portfolios
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

        Portfolio::updateOrCreate(
            ['slug' => 'redesign-portal-berita-nasional'],
            [
                'category_id' => $catApp->id,
                'title' => 'Desain Ulang Portal Berita Interaktif',
                'client' => 'IndoNews Media',
                'duration' => '3 Bulan',
                'technologies' => ['Next.js', 'Tailwind CSS', 'Figma', 'GraphQL'],
                'problem' => 'Kecepatan loading portal berita lambat di perangkat mobile sehingga meningkatkan bounce rate pengunjung hingga 70%.',
                'strategy' => 'Merancang ulang antarmuka visual yang modern dan menerapkan arsitektur Static Site Generation (SSG) performa tinggi.',
                'execution' => 'Perancangan desain UI/UX interaktif di Figma, implementasi Next.js dengan ISR, dan optimasi core web vitals.',
                'result' => 'Bounce rate turun menjadi 25% dan waktu load rata-rata di mobile terpangkas dari 5.2 detik ke 1.1 detik.',
                'solution' => 'Portal Berita Teroptimasi Kecepatan.',
                'image' => 'portfolios/news-portal.jpg'
            ]
        );

        // 5. Blogs
        Blog::updateOrCreate(
            ['slug' => '5-teknologi-web-modern-terbaik-2026'],
            [
                'category_id' => $catApp->id,
                'title' => '5 Teknologi Web Modern Terbaik di Tahun 2026',
                'content' => '<p>Dunia pengembangan web bergerak sangat cepat. Di tahun 2026 ini, beberapa teknologi telah dominasi industri karena kemampuannya memberikan performa maksimal dan efisiensi kode.</p><h3>1. Next.js 16</h3><p>Dengan peningkatan kecepatan compile dan dukungan server actions yang lebih matang, Next.js tetap menjadi andalan utama.</p><h3>2. Tailwind CSS v4</h3><p>Tailwind v4 menghadirkan mesin kompilasi baru yang jauh lebih ringan dan cepat.</p><p>Mengadopsi teknologi ini sekarang akan memberikan keunggulan kompetitif bagi produk digital bisnis Anda.</p>',
                'meta_title' => '5 Teknologi Web Modern Terbaik 2026 | Diggity Blog',
                'meta_description' => 'Pelajari 5 teknologi web development modern terbaik di tahun 2026 yang wajib diadopsi agensi dan bisnis digital untuk meningkatkan kecepatan website.',
                'image' => 'blogs/web-tech-2026.jpg'
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'panduan-seo-pemula-ranking-satu-google'],
            [
                'category_id' => $catBrand->id,
                'title' => 'Panduan SEO Pemula untuk Menembus Peringkat 1 Google',
                'content' => '<p>SEO (Search Engine Optimization) bukan lagi sekadar menaruh kata kunci di artikel. Google kini menilai pengalaman pengguna, kecepatan website, dan otoritas topik secara menyeluruh.</p><h3>Langkah Utama SEO:</h3><ul><li>Riset Keyword dengan intensi pencarian yang tepat.</li><li>Optimasi On-Page (struktur heading, kecepatan muat gambar).</li><li>Membangun Backlink berkualitas secara alami.</li></ul>',
                'meta_title' => 'Panduan Lengkap SEO Pemula 2026 | Diggity Blog',
                'meta_description' => 'Pelajari strategi SEO dasar terbaik untuk pemula agar website Anda mendapat peringkat pertama di halaman pencarian Google secara organik.',
                'image' => 'blogs/seo-guide.jpg'
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'cara-migrasi-server-ke-vps-tanpa-downtime'],
            [
                'category_id' => $catCloud->id,
                'title' => 'Cara Migrasi Server ke VPS Cloud Tanpa Downtime',
                'content' => '<p>Migrasi server seringkali menjadi momok karena risiko kehilangan data dan downtime transaksi. Namun, dengan langkah yang tepat, Anda bisa melakukannya secara mulus.</p><h3>Langkah Aman Migrasi:</h3><ul><li>Backup database secara menyeluruh.</li><li>Gunakan staging server untuk pengetesan.</li><li>Turunkan nilai TTL DNS sebelum mengalihkan domain.</li></ul>',
                'meta_title' => 'Cara Migrasi Server ke VPS Cloud Tanpa Downtime | Diggity Blog',
                'meta_description' => 'Panduan langkah demi langkah memigrasikan database dan file server Anda ke cloud VPS hosting secara aman tanpa mengalami offline.',
                'image' => 'blogs/server-migration.jpg'
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'pentingnya-ui-ux-design-untuk-retention-rate'],
            [
                'category_id' => $catApp->id,
                'title' => 'Pentingnya UI/UX Design untuk Meningkatkan Retention Rate',
                'content' => '<p>Aplikasi yang indah tidak ada gunanya jika pengguna kesulitan melakukan check-out. Pengalaman pengguna (UX) adalah kunci agar pelanggan terus kembali bertransaksi.</p><h3>Tips UX Berkonversi Tinggi:</h3><ul><li>Sederhanakan alur transaksi maksimal 3 langkah.</li><li>Gunakan hirarki tombol aksi (CTA) yang mencolok.</li><li>Sediakan feedback instan saat terjadi kesalahan input formulir.</li></ul>',
                'meta_title' => 'Pentingnya UI/UX Design untuk Retention Rate | Diggity Blog',
                'meta_description' => 'Pelajari korelasi erat antara desain antarmuka pengguna yang intuitif dengan peningkatan retensi kunjungan dan pembelian pelanggan.',
                'image' => 'blogs/ui-ux-retention.jpg'
            ]
        );

        Blog::updateOrCreate(
            ['slug' => '10-cara-meningkatkan-kecepatan-website-nextjs'],
            [
                'category_id' => $catApp->id,
                'title' => '10 Cara Meningkatkan Kecepatan Website Next.js Anda',
                'content' => '<p>Next.js sudah cepat, namun optimasi yang salah pada gambar dan dynamic package bisa memicu loading lambat. Berikut cara memaksimalkannya.</p><h3>Langkah Optimasi Next.js:</h3><ul><li>Gunakan komponen Next Image untuk kompresi otomatis.</li><li>Terapkan dynamic imports untuk modul yang berukuran besar.</li><li>Optimalkan server cache runtime.</li></ul>',
                'meta_title' => '10 Cara Meningkatkan Kecepatan Website Next.js | Diggity Blog',
                'meta_description' => 'Temukan teknik optimasi backend, caching, dan bundling untuk memangkas waktu loading website berbasis Next.js hingga dibawah 1 detik.',
                'image' => 'blogs/nextjs-speed.jpg'
            ]
        );

        // 6. Teams
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
        Team::updateOrCreate(
            ['name' => 'Rian Hidayat'],
            [
                'position' => 'Cloud Infrastructure Engineer',
                'photo' => null
            ]
        );
        Team::updateOrCreate(
            ['name' => 'Mega Lestari'],
            [
                'position' => 'Digital Marketing Specialist',
                'photo' => null
            ]
        );

        // 7. Testimonials
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
        Testimonial::updateOrCreate(
            ['client_name' => 'Gunawan Wibisono'],
            [
                'company' => 'PT Global Finance Indonesia',
                'review' => 'Infrastruktur multi-cloud yang dibangun Diggity sangat andal. Server kami tidak pernah mengalami down lagi saat lonjakan transaksi bulanan.',
                'rating' => 5,
                'avatar' => null
            ]
        );
        Testimonial::updateOrCreate(
            ['client_name' => 'Dian Sasmita'],
            [
                'company' => 'Edutech Nusantara',
                'review' => 'Corporate training Next.js dari Diggity meningkatkan produktivitas tim developer kami secara drastis. Materi sangat terstruktur dan aplikatif.',
                'rating' => 5,
                'avatar' => null
            ]
        );

        // 8. FAQs
        Faq::updateOrCreate(
            ['question' => 'Teknologi apa saja yang digunakan oleh Diggity?'],
            [
                'answer' => 'Kami menggunakan stack teknologi modern terbaik seperti Next.js, React, TypeScript, Tailwind CSS untuk frontend, serta Laravel, Node.js, dan PostgreSQL/MySQL untuk backend.'
            ]
        );
        Faq::updateOrCreate(
            ['question' => 'Berapa lama estimasi waktu pembuatan website atau aplikasi?'],
            [
                'answer' => 'Waktu pengerjaan bervariasi bergantung pada kompleksitas produk. Landing page standar membutuhkan waktu 1-2 minggu, sedangkan sistem ERP kustom atau aplikasi mobile biasanya memakan waktu 2-4 bulan.'
            ]
        );
        Faq::updateOrCreate(
            ['question' => 'Apakah Diggity menyediakan garansi pemeliharaan (maintenance)?'],
            [
                'answer' => 'Ya, setiap produk digital yang kami bangun mendapatkan garansi pemeliharaan gratis selama 3 bulan pertama setelah rilis untuk memastikan kestabilan sistem.'
            ]
        );
        Faq::updateOrCreate(
            ['question' => 'Bagaimana skema pembayaran untuk pengerjaan proyek kustom?'],
            [
                'answer' => 'Skema pembayaran dilakukan bertahap (term-based) berbasis milestone pengerjaan, biasanya dibagi menjadi DP awal, penyelesaian desain UI/UX, rilis versi beta, dan pelunasan saat go-live.'
            ]
        );
        Faq::updateOrCreate(
            ['question' => 'Apakah Diggity membantu migrasi server dari hosting lama?'],
            [
                'answer' => 'Ya, kami membantu migrasi basis data, file aset, serta penataan konfigurasi domain dari server hosting lama ke cloud server / VPS baru secara aman tanpa downtime.'
            ]
        );

        // 9. Pricings
        Pricing::updateOrCreate(
            ['name' => 'Starter Pack'],
            [
                'price' => 4999000,
                'period' => 'One-time',
                'features' => ['1 Landing Page Premium', 'Desain UI/UX Kustom', 'Responsif Mobile & Tablet', 'Integrasi Form Kontak', 'Domain & Hosting 1 Tahun', 'Garansi Bug-Fix 1 Bulan'],
                'is_popular' => false
            ]
        );
        Pricing::updateOrCreate(
            ['name' => 'Business Pro'],
            [
                'price' => 14999000,
                'period' => 'One-time',
                'features' => ['Hingga 5 Halaman Utama', 'CMS Admin Panel (Filament)', 'Integrasi Blog / News', 'Kecepatan Muat Super Cepat', 'Google Analytics & GTM Setup', 'SEO On-Page Dasar', 'Garansi Pemeliharaan 3 Bulan'],
                'is_popular' => true
            ]
        );
        Pricing::updateOrCreate(
            ['name' => 'Enterprise Custom'],
            [
                'price' => 29999000,
                'period' => 'One-time',
                'features' => ['Aplikasi Web / ERP Kustom', 'Aplikasi Mobile (Android/iOS)', 'Desain UX Kompleks & Animasi', 'Integrasi Payment Gateway', 'Keamanan Lapis Tinggi & Backup', 'Dukungan Prioritas 24/7'],
                'is_popular' => false
            ]
        );

        // 10. Careers
        Career::updateOrCreate(
            ['slug' => 'senior-fullstack-developer-laravel-nextjs'],
            [
                'title' => 'Senior Fullstack Developer (Laravel & Next.js)',
                'department' => 'App Builder Squad',
                'type' => 'Full-time',
                'location' => 'BSD City, Tangerang (Hybrid)',
                'description' => '<p>Kami mencari Senior Fullstack Developer berpengalaman untuk merancang, membangun, dan memelihara aplikasi web berskala enterprise menggunakan Laravel 12 dan Next.js 15.</p>',
                'requirements' => '<ul><li>Pengalaman kerja minimal 3 tahun sebagai Fullstack Web Developer.</li><li>Menguasai Laravel, PHP, Next.js, React, TypeScript, dan SQL database.</li><li>Memahami manajemen server VPS, Git, dan integrasi API pihak ketiga.</li></ul>',
                'is_active' => true
            ]
        );
        
        Career::updateOrCreate(
            ['slug' => 'digital-ads-specialist'],
            [
                'title' => 'Digital Ads Specialist (Google & Meta Ads)',
                'department' => 'Brand Growth Division',
                'type' => 'Full-time',
                'location' => 'Remote (Indonesia)',
                'description' => '<p>Kami mencari spesialis iklan digital yang andal untuk merancang kampanye iklan berbayar di Meta Ads, Google Ads, dan TikTok Ads guna mendatangkan prospek dan mengoptimalkan anggaran klien.</p>',
                'requirements' => '<ul><li>Pengalaman minimal 2 tahun dalam optimasi iklan berbayar dengan anggaran besar.</li><li>Mampu menganalisis data melalui Google Analytics 4 dan melakukan A/B testing audiens.</li><li>Memiliki sertifikasi resmi Google Ads atau Meta Blueprint adalah nilai plus.</li></ul>',
                'is_active' => true
            ]
        );

        Career::updateOrCreate(
            ['slug' => 'ui-ux-designer-designer-squad'],
            [
                'title' => 'UI/UX Designer',
                'department' => 'App Builder Squad',
                'type' => 'Full-time',
                'location' => 'BSD City, Tangerang (Hybrid)',
                'description' => '<p>Kami mencari desainer UI/UX kreatif yang memiliki passion kuat dalam menciptakan antarmuka pengguna yang estetik dan alur pengguna yang intuitif untuk website dan aplikasi mobile.</p>',
                'requirements' => '<ul><li>Pengalaman kerja minimal 2 tahun sebagai UI/UX Designer.</li><li>Mahir menggunakan Figma, Prototyping, dan pembuatan Design System.</li><li>Mampu melakukan riset pengguna dan mengimplementasikan feedback hasil testing.</li></ul>',
                'is_active' => true
            ]
        );

        Career::updateOrCreate(
            ['slug' => 'devops-cloud-engineer'],
            [
                'title' => 'DevOps & Cloud Engineer',
                'department' => 'Cloud Service Hub',
                'type' => 'Full-time',
                'location' => 'BSD City, Tangerang (Hybrid)',
                'description' => '<p>Kami mencari DevOps Engineer untuk mengelola infrastruktur cloud server, menjaga otomatisasi deployment CI/CD, serta mengoptimalkan sistem keamanan server.</p>',
                'requirements' => '<ul><li>Pengalaman minimal 2 tahun di bidang DevOps / Cloud Engineering.</li><li>Menguasai AWS / Google Cloud, Linux Administration, Docker, dan Kubernetes.</li><li>Mengerti pipeline CI/CD (GitHub Actions / GitLab CI) dan penataan keamanan Cloudflare.</li></ul>',
                'is_active' => true
            ]
        );
    }
}
