<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class AcademySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology And Software', 'description' => 'Website, Mobile App, Programming'],
            ['name' => 'AI And Data', 'description' => 'Machine Learning, Data Analytics, Gen AI'],
            ['name' => 'Creative And Design', 'description' => 'Graphic Design, UI/UX, Video'],
            ['name' => 'Marketing And Growth', 'description' => 'Digital Marketing, SEO, Ads'],
            ['name' => 'Cloud And Cyber Security', 'description' => 'Cloud, DevOps, Infrastructure'],
            ['name' => 'Business And Professional', 'description' => 'Business, Management, Product'],
        ];

        $categoryMap = [];
        foreach ($categories as $catData) {
            $cat = Category::firstOrCreate(
                ['slug' => Str::slug($catData['name']), 'type' => 'academy'],
                [
                    'name' => $catData['name'],
                    'description' => $catData['description'],
                ]
            );
            $categoryMap[$catData['name']] = $cat->id;
        }

        $courses = [
            // 1. Bootcamp
            [
                'category_id' => $categoryMap['Technology And Software'],
                'title' => 'Fullstack Web Development Bootcamp',
                'slug' => 'fullstack-web-development-bootcamp-v2',
                'type' => 'bootcamp',
                'description' => 'Bootcamp intensif 12 minggu. Pelajari React, Node.js, Express, dan MongoDB dari nol hingga siap kerja. Termasuk penyaluran kerja.',
                'syllabus' => "Minggu 1: HTML/CSS Lanjut\nMinggu 2: JavaScript Modern\nMinggu 3-5: React JS\nMinggu 6-8: Node & Express\nMinggu 9-10: MongoDB\nMinggu 11-12: Final Project & Career Prep",
                'instructor_name' => 'Ahmad Rizki',
                'instructor_title' => 'Engineering Manager',
                'instructor_bio' => 'Ahmad adalah Engineering Manager yang sering menguji kandidat developer baru.',
                'price' => 5000000,
                'original_price' => 7500000,
                'duration' => '3 Months',
                'rating' => 5.0,
                'reviews_count' => 120,
                'total_students' => 350,
                'badge' => 'Paling Diminati',
                'benefits' => [
                    ['feature' => 'Live mentoring 3x seminggu'],
                    ['feature' => 'Jaminan penyaluran kerja'],
                    ['feature' => 'Review CV & Portfolio'],
                ],
                'is_active' => true,
                'is_featured' => true,
            ],
            // 2. Online Course
            [
                'category_id' => $categoryMap['Technology And Software'],
                'title' => 'Mastering React & Next.js 14',
                'slug' => 'mastering-react-nextjs-14-v2',
                'type' => 'online_course',
                'description' => 'Pelajari web development modern menggunakan React, Next.js App Router, Tailwind CSS, dan Server Actions untuk membangun aplikasi production-ready.',
                'syllabus' => "Module 1: Introduction to Modern React\nModule 2: Hooks & State Management\nModule 3: Next.js 14 App Router Basics",
                'instructor_name' => 'Budi Santoso',
                'instructor_title' => 'Senior Frontend Engineer',
                'instructor_bio' => 'Budi sangat menyukai mengajar dan telah membantu ribuan siswa beralih ke industri teknologi.',
                'price' => 499000,
                'original_price' => 899000,
                'duration' => '24.5 Hours',
                'rating' => 4.9,
                'reviews_count' => 1250,
                'total_students' => 2100,
                'badge' => 'Best Seller',
                'benefits' => [
                    ['feature' => '24.5 Hours on-demand video'],
                    ['feature' => 'Downloadable resources'],
                    ['feature' => 'Access on mobile and desktop'],
                    ['feature' => 'Official Certificate'],
                ],
                'is_active' => true,
                'is_featured' => true,
            ],
            // 3. E-Book
            [
                'category_id' => $categoryMap['Technology And Software'],
                'title' => 'Clean Architecture Handbook',
                'slug' => 'clean-architecture-handbook',
                'type' => 'e_book',
                'description' => 'Buku digital 150+ halaman yang membahas tuntas implementasi Clean Architecture di ekosistem Node.js dan Laravel.',
                'syllabus' => "Bab 1: Pendahuluan\nBab 2: Domain Layer\nBab 3: Application Layer\nBab 4: Infrastructure Layer",
                'instructor_name' => 'Tim Engineer Diggity',
                'instructor_title' => 'Authors',
                'instructor_bio' => 'Ditulis oleh kumpulan engineer berpengalaman dari tim internal Diggity.',
                'price' => 150000,
                'original_price' => 300000,
                'duration' => '150 Pages',
                'rating' => 4.9,
                'reviews_count' => 450,
                'total_students' => 1200,
                'badge' => 'Terbaru',
                'benefits' => [
                    ['feature' => 'Format PDF & EPUB'],
                    ['feature' => 'Source code repository'],
                    ['feature' => 'Free update seumur hidup'],
                ],
                'is_active' => true,
                'is_featured' => false,
            ],
            // 4. Webinar
            [
                'category_id' => $categoryMap['AI And Data'],
                'title' => 'The Future of Gen-AI in Business',
                'slug' => 'future-gen-ai-business-webinar',
                'type' => 'webinar',
                'description' => 'Seminar online eksklusif membahas bagaimana Generative AI akan mengubah lanskap operasional bisnis di 5 tahun ke depan.',
                'syllabus' => "Sesi 1: Tren AI 2026\nSesi 2: Implementasi AI di UMKM\nSesi 3: Q&A",
                'instructor_name' => 'Dr. William AI',
                'instructor_title' => 'AI Researcher',
                'instructor_bio' => 'Peneliti terkemuka di bidang AI.',
                'price' => 50000,
                'original_price' => 150000,
                'duration' => '2 Hours',
                'rating' => 5.0,
                'reviews_count' => 80,
                'total_students' => 500,
                'badge' => 'Live',
                'benefits' => [
                    ['feature' => 'Akses Live Zoom'],
                    ['feature' => 'Rekaman Webinar'],
                    ['feature' => 'E-Certificate'],
                ],
                'is_active' => true,
                'is_featured' => true,
            ],
            // 5. Workshop
            [
                'category_id' => $categoryMap['Creative And Design'],
                'title' => 'Figma Prototyping Masterclass',
                'slug' => 'figma-prototyping-masterclass',
                'type' => 'workshop',
                'description' => 'Workshop intensif 2 hari secara tatap muka / live online untuk menguasai advanced prototyping dan micro-interactions di Figma.',
                'syllabus' => "Hari 1: Advanced Components\nHari 2: Micro-interactions & Prototyping",
                'instructor_name' => 'Sarah Wijaya',
                'instructor_title' => 'Lead Product Designer',
                'instructor_bio' => 'Designer produk dengan pengalaman di berbagai startup unicorn.',
                'price' => 750000,
                'original_price' => null,
                'duration' => '2 Days',
                'rating' => 4.8,
                'reviews_count' => 55,
                'total_students' => 100,
                'badge' => 'Terbatas',
                'benefits' => [
                    ['feature' => 'Mentoring langsung'],
                    ['feature' => 'Review karya oleh expert'],
                    ['feature' => 'Lunch & Merchandise (Offline)'],
                ],
                'is_active' => true,
                'is_featured' => false,
            ],
            // 6. Corporate Training
            [
                'category_id' => $categoryMap['Cloud And Cyber Security'],
                'title' => 'Cybersecurity Essentials for Enterprise',
                'slug' => 'cybersecurity-essentials-enterprise',
                'type' => 'corporate_training',
                'description' => 'Pelatihan in-house untuk staf IT perusahaan Anda. Fokus pada keamanan jaringan, mitigasi risiko, dan standar keamanan ISO 27001.',
                'syllabus' => "Modul 1: Keamanan Jaringan\nModul 2: Threat Modeling\nModul 3: Dasar Penetration Testing\nModul 4: Kepatuhan ISO 27001",
                'instructor_name' => 'Tim Konsultan Keamanan',
                'instructor_title' => 'Security Consultant',
                'instructor_bio' => 'Tim ahli cybersecurity bersertifikat.',
                'price' => 25000000,
                'original_price' => null,
                'duration' => '5 Days',
                'rating' => 4.9,
                'reviews_count' => 12,
                'total_students' => 15,
                'badge' => 'B2B',
                'benefits' => [
                    ['feature' => 'Kurikulum Kustom'],
                    ['feature' => 'Training di lokasi perusahaan'],
                    ['feature' => 'Sertifikasi Tim'],
                ],
                'is_active' => true,
                'is_featured' => true,
            ],
            // 7. Certification
            [
                'category_id' => $categoryMap['Marketing And Growth'],
                'title' => 'Certified Digital Performance Marketer',
                'slug' => 'certified-digital-performance-marketer',
                'type' => 'certification',
                'description' => 'Ujian sertifikasi standar industri untuk memvalidasi keahlian Anda dalam Digital Marketing (Meta Ads, Google Ads, Analytics).',
                'syllabus' => "Bagian 1: Ujian Teori (Pilihan Ganda)\nBagian 2: Ujian Praktik (Study Case Kampanye)",
                'instructor_name' => 'Badan Sertifikasi Diggity',
                'instructor_title' => 'Examiner',
                'instructor_bio' => 'Bekerja sama dengan asosiasi marketing digital Asia.',
                'price' => 1000000,
                'original_price' => null,
                'duration' => '120 Minutes',
                'rating' => 4.7,
                'reviews_count' => 200,
                'total_students' => 850,
                'badge' => 'Resmi',
                'benefits' => [
                    ['feature' => 'Sertifikat diakui industri'],
                    ['feature' => 'Badge LinkedIn'],
                    ['feature' => 'Akses tryout 1x'],
                ],
                'is_active' => true,
                'is_featured' => false,
            ],
            // 8. Scholarship
            [
                'category_id' => $categoryMap['Technology And Software'],
                'title' => 'Diggity Tech Scholarship 2026',
                'slug' => 'diggity-tech-scholarship-2026',
                'type' => 'scholarship',
                'description' => 'Program beasiswa penuh 100% untuk talenta digital dari keluarga prasejahtera. Mengikuti program Bootcamp selama 3 bulan tanpa biaya.',
                'syllabus' => "Sama dengan Fullstack Web Development Bootcamp",
                'instructor_name' => 'Diggity Foundation',
                'instructor_title' => 'CSR Team',
                'instructor_bio' => 'Lembaga nirlaba dari Diggity yang berfokus pada pendidikan inklusif.',
                'price' => 0,
                'original_price' => 5000000,
                'duration' => '3 Months',
                'rating' => 5.0,
                'reviews_count' => 50,
                'total_students' => 100,
                'badge' => 'Gratis',
                'benefits' => [
                    ['feature' => 'Beasiswa Penuh 100%'],
                    ['feature' => 'Bantuan perangkat (laptop)'],
                    ['feature' => 'Penyaluran kerja prioritas'],
                ],
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::firstOrNew(['slug' => $courseData['slug']]);
            $course->fill($courseData);
            
            // Translate the title & description automatically for bilingual frontend
            $course->en_title = $courseData['title'];
            $course->en_description = $courseData['description'];
            $course->en_syllabus = $courseData['syllabus'];
            $course->en_instructor_bio = $courseData['instructor_bio'];
            $course->en_instructor_title = $courseData['instructor_title'];
            
            $course->save();
        }
    }
}
