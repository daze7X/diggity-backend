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
            [
                'name' => 'Coding Bootcamps',
                'description' => 'Intensive coding bootcamps with industry-standard certification.',
            ],
            [
                'name' => 'Corporate IT Training',
                'description' => 'In-house customized tech training and upskilling for companies.',
            ],
            [
                'name' => 'Self-Paced E-Courses',
                'description' => 'Self-paced coding courses with quizzes and assessments.',
            ],
            [
                'name' => 'Digital E-Books',
                'description' => 'Download free programming guides and software engineering ebooks.',
            ],
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
                'category_id' => $categoryMap['Coding Bootcamps'],
                'title' => 'Fullstack Web Development (MERN Stack)',
                'slug' => 'fullstack-web-development-mern',
                'description' => 'Bootcamp intensif selama 12 minggu. Pelajari React, Node.js, Express, dan MongoDB dari nol hingga siap kerja. Termasuk penyaluran kerja dan sertifikasi industri.',
                'syllabus' => 'Minggu 1: HTML/CSS Lanjut, Minggu 2: JavaScript Modern, Minggu 3-5: React JS, Minggu 6-8: Node & Express, Minggu 9-10: MongoDB, Minggu 11-12: Final Project & Career Prep.',
                'instructor_name' => 'Budi Santoso',
                'instructor_title' => 'Senior Frontend Engineer',
                'price' => 5000000.00,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryMap['Corporate IT Training'],
                'title' => 'Cybersecurity Essentials for Enterprise',
                'slug' => 'cybersecurity-essentials-enterprise',
                'description' => 'Pelatihan in-house untuk staf IT perusahaan Anda. Fokus pada keamanan jaringan, mitigasi risiko, dan standar keamanan ISO 27001.',
                'syllabus' => 'Modul 1: Network Security, Modul 2: Threat Modeling, Modul 3: Penetration Testing Basics, Modul 4: ISO 27001 Compliance.',
                'instructor_name' => 'Rina Wijaya',
                'instructor_title' => 'Security Consultant',
                'price' => 15000000.00, // Harga korporat
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $categoryMap['Self-Paced E-Courses'],
                'title' => 'Mastering Next.js 14 (App Router)',
                'slug' => 'mastering-nextjs-14',
                'description' => 'Kursus mandiri (self-paced) untuk menguasai Next.js terbaru dengan App Router, Server Actions, dan Tailwind CSS. Tonton video kapan saja.',
                'syllabus' => '1. Pengenalan App Router, 2. Server vs Client Components, 3. Data Fetching, 4. Server Actions, 5. Deployment.',
                'instructor_name' => 'Diggity Team',
                'instructor_title' => 'Official Instructor',
                'price' => 450000.00,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryMap['Digital E-Books'],
                'title' => 'Buku Panduan Clean Architecture',
                'slug' => 'ebook-clean-architecture',
                'description' => 'E-book gratis setebal 100+ halaman yang membahas implementasi Clean Architecture pada project Node.js dan Laravel.',
                'syllabus' => 'Bab 1: Pendahuluan, Bab 2: Domain Layer, Bab 3: Application Layer, Bab 4: Infrastructure Layer, Bab 5: Presentation Layer.',
                'instructor_name' => 'Diggity Team',
                'instructor_title' => 'Authors',
                'price' => 0.00, // Gratis
                'is_active' => true,
                'is_featured' => false,
            ]
        ];

        foreach ($courses as $courseData) {
            Course::firstOrCreate(
                ['slug' => $courseData['slug']],
                $courseData
            );
        }
    }
}
