<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;

class AcademySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Kategori Academy sesuai dengan UI frontend
        $categories = [
            ['name' => 'Programming', 'description' => 'Learn coding and software engineering.'],
            ['name' => 'UI/UX Design', 'description' => 'Master user interface and user experience design.'],
            ['name' => 'Digital Marketing', 'description' => 'Learn SEO, SEM, and social media marketing.'],
            ['name' => 'Data Science', 'description' => 'Data analysis, machine learning, and AI.'],
            ['name' => 'Business', 'description' => 'Product management and business strategies.'],
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

        // 2. Buat Dummy Courses untuk masing-masing kategori
        $courses = [
            [
                'category_id' => $categoryMap['Programming'],
                'title' => 'Mastering React & Next.js 14',
                'slug' => 'mastering-react-nextjs-14',
                'type' => 'online_course',
                'description' => 'Pelajari web development modern menggunakan React, Next.js App Router, Tailwind CSS, dan Server Actions untuk membangun aplikasi production-ready.',
                'syllabus' => "Module 1: Introduction to Modern React\nModule 2: Hooks & State Management\nModule 3: Next.js 14 App Router Basics",
                'instructor_name' => 'Budi Santoso',
                'instructor_title' => 'Senior Frontend Engineer @ TechCorp',
                'instructor_bio' => 'Budi memiliki lebih dari 8 tahun pengalaman membangun aplikasi web skala besar. Ia sangat menyukai mengajar dan telah membantu ribuan siswa beralih ke industri teknologi.',
                'price' => 499000,
                'original_price' => 899000,
                'duration' => '24.5 Hours',
                'rating' => 4.9,
                'reviews_count' => 1250,
                'total_students' => 2100,
                'badge' => 'Best Seller',
                'benefits' => [
                    ['feature' => '24.5 Hours on-demand video'],
                    ['feature' => 'Downloadable resources & slides'],
                    ['feature' => 'Access on mobile and desktop'],
                    ['feature' => 'Official Certificate of completion'],
                    ['feature' => 'Access to community forum'],
                ],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryMap['UI/UX Design'],
                'title' => 'UI/UX Design for Beginners',
                'slug' => 'ui-ux-design-for-beginners',
                'type' => 'online_course',
                'description' => 'Mulai karir UI/UX design kamu dari nol. Belajar Figma, wireframing, dan dasar-dasar riset pengguna.',
                'syllabus' => "Module 1: Design Fundamentals\nModule 2: Mastering Figma\nModule 3: User Research",
                'instructor_name' => 'Sarah Wijaya',
                'instructor_title' => 'Lead Product Designer',
                'instructor_bio' => 'Sarah adalah desainer produk dengan pengalaman di berbagai startup unicorn.',
                'price' => 399000,
                'original_price' => null,
                'duration' => '15 Hours',
                'rating' => 4.8,
                'reviews_count' => 890,
                'total_students' => 1800,
                'badge' => 'New',
                'benefits' => [
                    ['feature' => '15 Hours on-demand video'],
                    ['feature' => 'Figma UI Kits included'],
                    ['feature' => 'Official Certificate of completion'],
                ],
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $categoryMap['Programming'],
                'title' => 'Fullstack Web Development Bootcamp',
                'slug' => 'fullstack-web-development-bootcamp',
                'type' => 'bootcamp',
                'description' => 'Bootcamp intensif selama 12 minggu. Pelajari React, Node.js, Express, dan MongoDB dari nol hingga siap kerja.',
                'syllabus' => "Minggu 1: HTML/CSS Lanjut\nMinggu 2: JavaScript Modern\nMinggu 3-5: React JS",
                'instructor_name' => 'Ahmad Rizki',
                'instructor_title' => 'Engineering Manager',
                'instructor_bio' => 'Ahmad adalah Engineering Manager yang sering menguji kandidat developer baru.',
                'price' => 5000000,
                'original_price' => 7500000,
                'duration' => '3 Months',
                'rating' => 5.0,
                'reviews_count' => 120,
                'total_students' => 350,
                'badge' => 'Intensive',
                'benefits' => [
                    ['feature' => 'Live mentoring 3x seminggu'],
                    ['feature' => 'Jaminan penyaluran kerja'],
                    ['feature' => 'Review CV & Portfolio'],
                ],
                'is_active' => true,
                'is_featured' => true,
            ]
        ];

        foreach ($courses as $courseData) {
            $course = Course::firstOrNew(['slug' => $courseData['slug']]);
            $course->fill($courseData);
            $course->save();
        }
    }
}
