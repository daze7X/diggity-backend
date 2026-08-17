<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Blog;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Pricing;
use App\Models\CompanySetting;
use App\Models\Lead;
use App\Models\Career;
use App\Models\JobApplication;
use App\Models\Subscriber;
use App\Models\Product;
use App\Models\Course;
use App\Models\TalentProfile;
use App\Mail\LeadSubmittedMail;
use App\Mail\JobApplicationSubmittedMail;
use Illuminate\Support\Facades\Http;

/**
 * Verify Google reCAPTCHA v3 token.
 * Gracefully bypasses if RECAPTCHA_SECRET_KEY is empty in .env.
 */
function verifyRecaptcha(?string $token, string $action): bool
{
    $secret = config('services.recaptcha.secret_key');
    if (empty($secret)) {
        Log::info("[reCAPTCHA Mock] Bypassed verification for action '{$action}' with token: " . ($token ?? 'none'));
        return true;
    }

    if (empty($token)) {
        Log::warning("[reCAPTCHA] Validation failed: Token is empty for action '{$action}'.");
        return false;
    }

    try {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
        ]);

        if ($response->successful()) {
            $body = $response->json();
            $success = $body['success'] ?? false;
            $score = $body['score'] ?? 0;
            
            Log::info("[reCAPTCHA] Verification for action '{$action}' - Success: " . ($success ? 'true' : 'false') . ", Score: {$score}");
            
            return $success && $score >= 0.5;
        }

        Log::error("[reCAPTCHA] Request failed: " . $response->body());
        return false;
    } catch (\Exception $e) {
        Log::error("[reCAPTCHA Exception] Error occurred: " . $e->getMessage());
        return false;
    }
}


// GET /api/company-settings
Route::get('/company-settings', function () {
    return response()->json(CompanySetting::first() ?? [
        'name' => 'Diggity Agency',
        'email' => 'hello@diggity.com',
        'whatsapp' => '628123456789',
        'address' => 'Jakarta, Indonesia',
        'instagram_url' => 'https://instagram.com/diggity.id',
        'linkedin_url' => 'https://linkedin.com'
    ]);
});

// GET /api/services
Route::get('/services', function () {
    return response()->json(Service::with('category')->get());
});

// GET /api/services/{slug}
Route::get('/services/{slug}', function ($slug) {
    $service = Service::with('category')->where('slug', $slug)->firstOrFail();
    return response()->json($service);
});

// GET /api/run-migrations
Route::get('/run-migrations', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return response()->json([
            'status' => 'success',
            'message' => 'Migrations executed successfully!',
            'output' => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// GET /api/talent-services/{slug}
Route::get('/talent-services/{slug}', function ($slug) {
    $defaultHeadhunting = [
        'title' => 'IT Headhunting',
        'sub_title' => 'Pemetaan Kebutuhan Teknis',
        'description' => 'Kami membantu perusahaan menjaring, menyaring, dan merekrut talenta digital teratas—mulai dari Software Engineers hingga CTO—dengan kualifikasi teknis presisi serta budaya kerja yang selaras.',
        'process_tabs' => [
            [
                'title' => '1. Analisis Profil',
                'subtitle' => 'Pemetaan Kebutuhan Teknis',
                'content' => 'Kami duduk bersama dengan tim Anda untuk merumuskan deskripsi pekerjaan secara detail, menentukan kualifikasi teknis (tech stack) yang dibutuhkan, serta menyelaraskan kriteria soft skill dan kepribadian (cultural fit) agar kandidat dapat langsung menyatu dengan tim internal Anda.'
            ],
            [
                'title' => '2. Sourcing & Screening',
                'subtitle' => 'Pencarian & Penjaringan Kandidat',
                'content' => 'Tim perekrut ahli kami menyaring kandidat potensial dari basis data internal bersertifikat Diggity dan jaringan global kami. Kami melakukan pre-screening teknis, review portfolio koding, dan wawancara awal sebelum merekomendasikan mereka.'
            ],
            [
                'title' => '3. Wawancara Klien',
                'subtitle' => 'Presentasi & Seleksi Final',
                'content' => 'Kami menyajikan CV beserta hasil penilaian teknis (technical test) dari 2-3 kandidat terbaik untuk Anda wawancarai langsung. Kami membantu menjadwalkan wawancara dan menjadi penengah proses feedback demi kesepakatan terbaik.'
            ],
            [
                'title' => '4. Onboarding & Garansi',
                'subtitle' => 'Penempatan & Jaminan Kinerja',
                'content' => 'Setelah penawaran diterima, kami mendampingi masa transisi kandidat hingga resmi onboarding di perusahaan Anda. Untuk menjamin kenyamanan Anda, kami memberikan garansi penggantian kandidat gratis hingga 90 hari jika terjadi ketidakcocokan.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'Berapa biaya jasa IT Headhunting di Diggity?',
                'a' => 'Biaya headhunting didasarkan pada persentase remunerasi tahunan kandidat yang disetujui (Annual Package), atau melalui skema harga flat terjangkau yang disesuaikan dengan tingkat kesulitan posisi. Kami mengadopsi model "Success Fee", yang berarti Anda hanya membayar setelah kandidat resmi menandatangani kontrak kerja.'
            ],
            [
                'q' => 'Bagaimana jika kandidat mengundurkan diri dalam masa percobaan?',
                'a' => 'Diggity memberikan jaminan garansi penggantian talenta (replacement guarantee) secara gratis selama 90 hari terhitung sejak tanggal onboarding kandidat. Kami akan segera mencarikan kandidat pengganti baru tanpa mengenakan biaya tambahan apa pun.'
            ],
            [
                'q' => 'Berapa lama waktu yang dibutuhkan untuk mendapatkan kandidat?',
                'a' => 'Untuk posisi junior hingga mid-level, kami biasanya menyajikan kandidat terpilih pertama dalam waktu 7–10 hari kerja. Untuk posisi senior, manajerial, atau tech stack yang sangat langka, proses penyaringan dapat memakan waktu 14–21 hari kerja.'
            ],
            [
                'q' => 'Apakah seluruh kandidat sudah melalui tes kompetensi?',
                'a' => 'Tentu kawan. Seluruh kandidat yang kami teruskan ke klien telah melalui tes penyaringan awal secara internal yang mencakup penilaian algoritma, live coding review, pemecahan masalah (case study), serta asesmen komunikasi profesional.'
            ]
        ]
    ];

    $defaultOutsourcing = [
        'title' => 'IT Outsourcing',
        'sub_title' => 'Managed IT Squads',
        'description' => 'Beban operasional nol, fokus hasil maksimal. Kami menyediakan tim pengembang lengkap (Full Squad) yang dikelola penuh oleh Diggity untuk merancang dan meluncurkan produk digital Anda tanpa kendala rekrutmen.',
        'process_tabs' => [
            [
                'title' => '1. Analisis Kebutuhan',
                'subtitle' => 'Identifikasi Peran & Skill',
                'content' => 'Kami menganalisis kebutuhan produk digital Anda untuk merumuskan struktur tim terbaik (seperti Frontend, Backend, UI/UX, QA, dan Project Manager) beserta kualifikasi keahlian teknis yang diperlukan.'
            ],
            [
                'title' => '2. Sourcing & Penyusunan',
                'subtitle' => 'Pemilihan Anggota Tim',
                'content' => 'Kami menyusun tim IT handal dari jaringan developer berpengalaman kami yang telah teruji dalam berbagai proyek berskala besar.'
            ],
            [
                'title' => '3. Uji Coba Kinerja',
                'subtitle' => 'Adaptasi & Penyelarasan Alur',
                'content' => 'Sebelum resmi dideploy penuh, tim kami melakukan sinkronisasi alur kerja menggunakan metodologi Agile/Scrum untuk menjamin kolaborasi yang mulus dengan tim internal Anda.'
            ],
            [
                'title' => '4. Delivery & Manajemen',
                'subtitle' => 'Pengawasan Kontinu',
                'content' => 'Tim kami bekerja secara mandiri di bawah pengawasan Project Manager kami untuk merancang produk Anda, sementara Anda menerima update berkala dan memegang kendali atas prioritas fitur.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'Apakah kami bisa menyewa satu orang developer saja?',
                'a' => 'Tentu kawan. Kami menyediakan skema sewa talenta individu (Dedicated Talent) maupun satu tim pengembang lengkap (Full Squad) sesuai dengan skala dan kompleksitas proyek kawan.'
            ],
            [
                'q' => 'Bagaimana skema pembayaran jasa outsourcing ini?',
                'a' => 'Skema pembayaran dilakukan setiap bulan (Monthly Retainer) berdasarkan jumlah anggota tim dan kualifikasi keahlian developer yang kawan sewa. Semua urusan asuransi, THR, pajak, dan perangkat kerja dikelola penuh oleh Diggity.'
            ],
            [
                'q' => 'Apakah tim pengembang bisa bekerja langsung di kantor kami?',
                'a' => 'Tim outsourcing kami umumnya bekerja secara jarak jauh (Remote), namun kami mendukung opsi pengerjaan di kantor klien (On-site) di wilayah Jabodetabek untuk koordinasi tertentu.'
            ]
        ]
    ];

    $default = $slug === 'outsourcing' ? $defaultOutsourcing : $defaultHeadhunting;

    $service = \App\Models\TalentService::firstOrCreate(['slug' => $slug], $default);
    return response()->json($service);
});

// GET /api/portfolios
Route::get('/portfolios', function () {
    $portfolios = Portfolio::with('category')->latest()->get();
    foreach ($portfolios as $portfolio) {
        $portfolio->testimonial = Testimonial::where('company', $portfolio->client)->first();
    }
    return response()->json($portfolios);
});

// GET /api/portfolios/{slug}
Route::get('/portfolios/{slug}', function ($slug) {
    $portfolio = Portfolio::with('category')->where('slug', $slug)->firstOrFail();
    $testimonial = Testimonial::where('company', $portfolio->client)->first();
    $portfolio->testimonial = $testimonial;
    return response()->json($portfolio);
});

// GET /api/blogs
Route::get('/blogs', function () {
    return response()->json(Blog::with('category')->latest()->get());
});

// GET /api/blogs/{slug}
Route::get('/blogs/{slug}', function ($slug) {
    $blog = Blog::with('category')->where('slug', $slug)->firstOrFail();
    return response()->json($blog);
});

// GET /api/search
Route::get('/search', function (Request $request) {
    $query = $request->query('q');
    if (empty($query)) {
        return response()->json([
            'services' => [],
            'portfolios' => [],
            'blogs' => []
        ]);
    }

    $lowerQuery = mb_strtolower($query, 'UTF-8');

    $services = Service::with('category')
        ->where(function($q) use ($lowerQuery) {
            $q->whereRaw('LOWER(name) LIKE ?', ["%{$lowerQuery}%"])
              ->orWhereRaw('LOWER(description) LIKE ?', ["%{$lowerQuery}%"]);
        })
        ->limit(5)
        ->get();

    $portfolios = Portfolio::with('category')
        ->where(function($q) use ($lowerQuery) {
            $q->whereRaw('LOWER(title) LIKE ?', ["%{$lowerQuery}%"])
              ->orWhereRaw('LOWER(problem) LIKE ?', ["%{$lowerQuery}%"])
              ->orWhereRaw('LOWER(solution) LIKE ?', ["%{$lowerQuery}%"]);
        })
        ->limit(5)
        ->get();

    $blogs = Blog::with('category')
        ->where(function($q) use ($lowerQuery) {
            $q->whereRaw('LOWER(title) LIKE ?', ["%{$lowerQuery}%"])
              ->orWhereRaw('LOWER(content) LIKE ?', ["%{$lowerQuery}%"]);
        })
        ->limit(5)
        ->get();

    return response()->json([
        'services' => $services,
        'portfolios' => $portfolios,
        'blogs' => $blogs
    ]);
});

// GET /api/teams
Route::get('/teams', function () {
    return response()->json(Team::all());
});

// GET /api/testimonials
Route::get('/testimonials', function () {
    return response()->json(Testimonial::all());
});

// GET /api/faqs
Route::get('/faqs', function () {
    return response()->json(Faq::all());
});

// GET /api/pricings
Route::get('/pricings', function () {
    return response()->json(Pricing::all());
});

// GET /api/careers
Route::get('/careers', function () {
    return response()->json(Career::where('is_active', 'true')->latest()->get());
});

// GET /api/careers/{slug}
Route::get('/careers/{slug}', function ($slug) {
    $career = Career::where('slug', $slug)->firstOrFail();
    return response()->json($career);
});

// POST /api/leads
Route::post('/leads', function (Request $request) {
    if (!verifyRecaptcha($request->input('recaptcha_token'), 'contact')) {
        return response()->json([
            'success' => false,
            'message' => 'Verifikasi reCAPTCHA spam bot gagal. Silakan coba kembali.'
        ], 422);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:50',
        'company' => 'nullable|string|max:255',
        'service' => 'nullable|string|max:255',
        'message' => 'required|string',
    ]);

    $lead = Lead::create($validated);

    // Fetch dynamic recipient email from Company Settings
    $settings = CompanySetting::first();
    $recipientEmail = $settings?->email ?? 'sales@diggity.com';

    try {
        Mail::to($recipientEmail)->send(new LeadSubmittedMail($lead));
    } catch (\Exception $e) {
        Log::error('Failed to send lead email notification: ' . $e->getMessage());
    }

    return response()->json([
        'success' => true,
        'message' => 'Lead submitted successfully',
        'data' => $lead
    ], 201);
});

// POST /api/subscribers
Route::post('/subscribers', function (Request $request) {
    if (!verifyRecaptcha($request->input('recaptcha_token'), 'newsletter')) {
        return response()->json([
            'success' => false,
            'message' => 'Verifikasi reCAPTCHA spam bot gagal. Silakan coba kembali.'
        ], 422);
    }

    $validated = $request->validate([
        'email' => 'required|email|max:255',
    ]);

    $subscriber = Subscriber::where('email', $validated['email'])->first();

    if ($subscriber && $subscriber->status === 'active') {
        return response()->json([
            'success' => false,
            'message' => 'Email Anda sudah terdaftar dan aktif.'
        ], 422);
    }

    if ($subscriber) {
        $subscriber->update(['status' => 'active']);
    } else {
        $subscriber = Subscriber::create([
            'email' => $validated['email'],
            'status' => 'active'
        ]);
    }

    // Sync to Mailchimp (subscribes member)
    \App\Services\MailchimpService::syncSubscriber($validated['email'], 'subscribed');

    return response()->json([
        'success' => true,
        'message' => 'Subscribed successfully',
        'data' => $subscriber
    ], 201);
});

// POST /api/subscribers/unsubscribe
Route::post('/subscribers/unsubscribe', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|max:255',
    ]);

    $subscriber = Subscriber::where('email', $validated['email'])->first();

    if (!$subscriber) {
        return response()->json([
            'success' => false,
            'message' => 'Email tidak ditemukan di sistem kami.'
        ], 404);
    }

    if ($subscriber->status === 'inactive') {
        return response()->json([
            'success' => true,
            'message' => 'Email Anda sudah dalam status berhenti berlangganan.'
        ]);
    }

    $subscriber->update(['status' => 'inactive']);

    // Sync to Mailchimp (unsubscribes member)
    \App\Services\MailchimpService::syncSubscriber($validated['email'], 'unsubscribed');

    return response()->json([
        'success' => true,
        'message' => 'Anda telah sukses berhenti berlangganan dari newsletter kami.'
    ]);
});

// POST /api/job-applications
Route::post('/job-applications', function (Request $request) {
    if (!verifyRecaptcha($request->input('recaptcha_token'), 'career')) {
        return response()->json([
            'success' => false,
            'message' => 'Verifikasi reCAPTCHA spam bot gagal. Silakan coba kembali.'
        ], 422);
    }

    $validated = $request->validate([
        'career_id' => 'required|exists:careers,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:50',
        'cv' => 'required|file|mimes:pdf|max:10240', // PDF up to 10MB
        'cover_letter' => 'nullable|string',
    ]);

    // Store CV PDF in private 'local' disk
    $cvPath = $request->file('cv')->store('cvs', 'local');

    $application = JobApplication::create([
        'career_id' => $validated['career_id'],
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'cv_path' => $cvPath,
        'cover_letter' => $validated['cover_letter'] ?? null,
        'status' => 'applied'
    ]);

    // Load career relationship for the email mailable
    $application->load('career');

    // Fetch dynamic recipient email from Company Settings
    $settings = CompanySetting::first();
    $recipientEmail = $settings?->email ?? 'hrd@diggity.com';

    try {
        Mail::to($recipientEmail)->send(new JobApplicationSubmittedMail($application));
    } catch (\Exception $e) {
        Log::error('Failed to send job application email notification: ' . $e->getMessage());
    }

    return response()->json([
        'success' => true,
        'message' => 'Application submitted successfully',
        'data' => $application
    ], 201);
});

// ==========================================
// NEW V1.1 API ROUTE ENDPOINTS
// ==========================================

// SOLUTIONS (Services)
Route::get('/solutions', function () {
    return response()->json(Service::with('category')->get());
});

Route::get('/solutions/{slug}', function ($slug) {
    return response()->json(Service::with(['category', 'seoMeta'])->where('slug', $slug)->firstOrFail());
});

// PRODUCTS
Route::get('/products', function () {
    return response()->json(Product::with('category')->where('is_active', 'true')->get());
});

Route::get('/products/{slug}', function ($slug) {
    return response()->json(Product::with(['category', 'seoMeta'])->where('slug', $slug)->firstOrFail());
});

// ACADEMY (LMS)
Route::get('/academy', function () {
    return response()->json(Course::with('category')->where('is_active', 'true')->get());
});

Route::get('/academy/{slug}', function ($slug) {
    return response()->json(Course::with(['category', 'modules.lessons', 'seoMeta'])->where('slug', $slug)->firstOrFail());
});

// INSIGHTS (Blogs)
Route::get('/insights', function () {
    return response()->json(Blog::with('category')->latest()->get());
});

Route::get('/insights/{slug}', function ($slug) {
    return response()->json(Blog::with(['category', 'seoMeta'])->where('slug', $slug)->firstOrFail());
});

// JOB CONNECT
Route::get('/job-connect', function () {
    return response()->json(Career::where('is_active', 'true')->latest()->get());
});

Route::get('/job-connect/{slug}', function ($slug) {
    return response()->json(Career::with(['seoMeta'])->where('slug', $slug)->firstOrFail());
});

Route::post('/talent-profiles', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'type' => 'required|string|in:individual,dedicated_team',
        'skills' => 'nullable|array',
        'portfolio_links' => 'nullable|array',
        'description' => 'nullable|string',
    ]);

    $profile = TalentProfile::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Talent profile submitted successfully',
        'data' => $profile
    ], 201);
});

// ==========================================
// USER AUTHENTICATION & PORTAL API
// ==========================================
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'customer', // default role
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'user' => $user,
        'token' => $token,
    ], 201);
});

Route::post('/login', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $validated['email'])->first();

    if (! $user || ! Hash::check($validated['password'], $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'user' => $user,
        'token' => $token,
    ]);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    });

    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::put('/user', function (Request $request) {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    });

    Route::get('/user/orders', function (Request $request) {
        $orders = $request->user()->orders()->with('items.product')->latest()->get();
        return response()->json($orders);
    });

    Route::get('/user/products', function (Request $request) {
        $licenses = $request->user()->licenses()->with('product')->get();
        return response()->json($licenses);
    });

    Route::get('/user/courses', function (Request $request) {
        $enrollments = $request->user()->enrollments()->with(['course.category', 'progressTrackings'])->get();
        return response()->json($enrollments);
    });

    Route::get('/user/courses/{slug}/learn', function (Request $request, $slug) {
        $user = $request->user();
        
        $course = \App\Models\Course::with(['modules.lessons' => function ($q) {
            $q->orderBy('sort_order', 'asc');
        }])->where('slug', $slug)->firstOrFail();

        $enrollment = \App\Models\Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['active', 'completed'])
            ->first();

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses aktif untuk kelas ini.'
            ], 403);
        }

        $completedLessonIds = \App\Models\ProgressTracking::where('enrollment_id', $enrollment->id)
            ->where('is_completed', 'true')
            ->pluck('lesson_id')
            ->toArray();

        return response()->json([
            'success' => true,
            'course' => $course,
            'completed_lessons' => $completedLessonIds
        ]);
    });

    Route::post('/user/courses/{slug}/lessons/{lesson_id}/complete', function (Request $request, $slug, $lessonId) {
        $user = $request->user();

        $course = \App\Models\Course::where('slug', $slug)->firstOrFail();
        
        $enrollment = \App\Models\Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['active', 'completed'])
            ->first();

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak.'
            ], 403);
        }

        // Verify lesson belongs to the course
        $lesson = \App\Models\Lesson::where('id', $lessonId)
            ->whereHas('module', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })->firstOrFail();

        \App\Models\ProgressTracking::updateOrCreate(
            [
                'enrollment_id' => $enrollment->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'is_completed' => 'true',
                'completed_at' => now(),
            ]
        );

        // Check if all lessons completed to mark course completed
        $totalLessons = \App\Models\Lesson::whereHas('module', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })->count();

        $completedCount = \App\Models\ProgressTracking::where('enrollment_id', $enrollment->id)
            ->where('is_completed', 'true')
            ->count();

        if ($completedCount >= $totalLessons) {
            $enrollment->status = 'completed';
            $enrollment->completed_at = now();
            $enrollment->save();

            // Generate Certificate if not exists
            $certificate = \App\Models\Certificate::where('enrollment_id', $enrollment->id)->first();
            if (!$certificate) {
                // Generate a unique verification hash (sha256 of enrollment_id, user_id, and time)
                $verificationHash = hash('sha256', $enrollment->id . '-' . $user->id . '-' . time());

                // Generate certificate number: CERT/DGTY/YYYYMM/RANDOM(4 chars)
                $yearMonth = now()->format('Ym');
                $randomStr = strtoupper(\Illuminate\Support\Str::random(4));
                // Ensure unique certificate number
                do {
                    $certificateNumber = "CERT/DGTY/{$yearMonth}/{$randomStr}";
                    $exists = \App\Models\Certificate::where('certificate_number', $certificateNumber)->exists();
                    if ($exists) {
                        $randomStr = strtoupper(\Illuminate\Support\Str::random(4));
                    }
                } while ($exists);

                \App\Models\Certificate::create([
                    'enrollment_id' => $enrollment->id,
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'certificate_number' => $certificateNumber,
                    'verification_hash' => $verificationHash,
                    'issued_at' => now(),
                ]);
            }
        }

        $completedLessonIds = \App\Models\ProgressTracking::where('enrollment_id', $enrollment->id)
            ->where('is_completed', 'true')
            ->pluck('lesson_id')
            ->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Progres materi berhasil disimpan.',
            'completed_lessons' => $completedLessonIds,
            'enrollment_status' => $enrollment->status
        ]);
    });

    Route::post('/checkout', function (Request $request) {
        $user = $request->user();

        $validated = $request->validate([
            'purchasable_type' => 'required|string|in:product,course',
            'purchasable_id' => 'required|integer',
        ]);

        $type = $validated['purchasable_type'];
        $id = $validated['purchasable_id'];

        $purchasableModel = null;
        $price = 0;
        $itemName = '';

        if ($type === 'product') {
            $purchasableModel = \App\Models\Product::findOrFail($id);
            $price = $purchasableModel->price;
            $itemName = $purchasableModel->name;

            // Check if already has license
            $hasLicense = \App\Models\UserLicense::where('user_id', $user->id)
                ->where('product_id', $id)
                ->where('status', 'active')
                ->exists();

            if ($hasLicense) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memiliki lisensi aktif untuk produk ini.'
                ], 400);
            }
        } else {
            $purchasableModel = \App\Models\Course::findOrFail($id);
            $price = $purchasableModel->price;
            $itemName = $purchasableModel->title;

            // Check if already enrolled
            $isEnrolled = \App\Models\Enrollment::where('user_id', $user->id)
                ->where('course_id', $id)
                ->whereIn('status', ['active', 'completed'])
                ->exists();

            if ($isEnrolled) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar di kelas ini.'
                ], 400);
            }
        }

        // Create Order
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'order_number' => 'DGTY-' . time() . '-' . rand(1000, 9999),
            'total_amount' => $price,
            'status' => 'pending',
            'payment_method' => 'midtrans',
            'payment_status' => 'pending',
        ]);

        // Create OrderItem
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'purchasable_type' => get_class($purchasableModel),
            'purchasable_id' => $purchasableModel->id,
            'price' => $price,
            'quantity' => 1,
        ]);

        // Midtrans Parameters
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $purchasableModel->id,
                    'price' => (int) $order->total_amount,
                    'quantity' => 1,
                    'name' => substr($itemName, 0, 50),
                ]
            ]
        ];

        $snapToken = '';
        $redirectUrl = '';

        try {
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-your-key');
            \Midtrans\Config::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $redirectUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Exception: ' . $e->getMessage());
            // Fallback mock payment simulator
            $snapToken = 'mock-snap-token-' . uniqid();
            $redirectUrl = url('/api/payment/mock-payment?order=' . $order->order_number);
        }

        return response()->json([
            'success' => true,
            'order' => $order,
            'snap_token' => $snapToken,
            'redirect_url' => $redirectUrl
        ]);
    });

    // GET /api/user/certificates
    Route::get('/user/certificates', function (Request $request) {
        $user = $request->user();
        $certificates = \App\Models\Certificate::with('course')
            ->where('user_id', $user->id)
            ->orderBy('issued_at', 'desc')
            ->get();
        return response()->json([
            'success' => true,
            'certificates' => $certificates
        ]);
    });

    // ==========================================
    // SUPPORT TICKET SYSTEM ENDPOINTS (USR-6.1)
    // ==========================================
    
    // GET /api/user/tickets - Get user's tickets list
    Route::get('/user/tickets', function (Request $request) {
        $user = $request->user();
        $tickets = \App\Models\SupportTicket::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json([
            'success' => true,
            'tickets' => $tickets
        ]);
    });

    // POST /api/user/tickets - Create a new ticket
    Route::post('/user/tickets', function (Request $request) {
        $user = $request->user();
        
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|string|in:billing,technical,general',
            'message' => 'required|string',
        ]);

        // Generate ticket number: TCK-YYYYMM-RANDOM
        $ticketNumber = 'TCK-' . now()->format('Ym') . '-' . strtoupper(\Illuminate\Support\Str::random(5));

        $ticket = \App\Models\SupportTicket::create([
            'user_id' => $user->id,
            'ticket_number' => $ticketNumber,
            'subject' => $validated['subject'],
            'category' => $validated['category'],
            'status' => 'open',
            'priority' => 'medium',
        ]);

        // Create the first message
        \App\Models\SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket bantuan berhasil dibuat.',
            'ticket' => $ticket
        ], 201);
    });

    // GET /api/user/tickets/{id} - Get ticket details & messages thread
    Route::get('/user/tickets/{id}', function (Request $request, $id) {
        $user = $request->user();
        $ticket = \App\Models\SupportTicket::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $messages = \App\Models\SupportMessage::with('user:id,name,role')
            ->where('support_ticket_id', $ticket->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'ticket' => $ticket,
            'messages' => $messages
        ]);
    });

    // POST /api/user/tickets/{id}/reply - Reply to a ticket thread
    Route::post('/user/tickets/{id}/reply', function (Request $request, $id) {
        $user = $request->user();
        
        $ticket = \App\Models\SupportTicket::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $message = \App\Models\SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        // Reopen ticket if resolved/closed
        if (in_array($ticket->status, ['resolved', 'closed'])) {
            $ticket->status = 'open';
        }
        $ticket->touch(); // Update updated_at
        $ticket->save();

        $message->load('user:id,name,role');

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim.',
            'sent_message' => $message,
            'ticket' => $ticket
        ], 201);
    });
});

// GET /api/certificates/verify/{hash} (Public)
Route::get('/certificates/verify/{hash}', function ($hash) {
    $certificate = \App\Models\Certificate::with(['user', 'course'])
        ->where('verification_hash', $hash)
        ->first();

    if (!$certificate) {
        return response()->json([
            'success' => false,
            'message' => 'Sertifikat tidak ditemukan atau tidak valid.'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'certificate' => [
            'number' => $certificate->certificate_number,
            'hash' => $certificate->verification_hash,
            'issued_at' => $certificate->issued_at->toIso8601String(),
            'recipient_name' => $certificate->user->name,
            'course_title' => $certificate->course->title,
            'course_slug' => $certificate->course->slug,
            'instructor_name' => $certificate->course->instructor_name,
            'instructor_title' => $certificate->course->instructor_title,
        ]
    ]);
});

// ==========================================
// MIDTRANS PAYMENT CALLBACK & SIMULATOR API
// ==========================================
Route::post('/payment/callback', function (Request $request) {
    // Decode Midtrans payload
    $orderNumber = $request->input('order_id');
    $transactionStatus = $request->input('transaction_status');
    $fraudStatus = $request->input('fraud_status');

    $order = \App\Models\Order::where('order_number', $orderNumber)->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found'
        ], 404);
    }

    if ($order->payment_status === 'paid') {
        return response()->json([
            'success' => true,
            'message' => 'Order already processed'
        ]);
    }

    $isSuccess = false;

    if ($transactionStatus == 'capture') {
        if ($fraudStatus == 'challenge') {
            // CHALLENGE
        } else if ($fraudStatus == 'accept') {
            $isSuccess = true;
        }
    } else if ($transactionStatus == 'settlement') {
        $isSuccess = true;
    } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
        $order->payment_status = 'failed';
        $order->status = 'cancelled';
        $order->save();
    }

    if ($isSuccess) {
        $order->payment_status = 'paid';
        $order->status = 'completed';
        $order->save();

        // Process purchased items
        $items = \App\Models\OrderItem::where('order_id', $order->id)->get();
        foreach ($items as $item) {
            if ($item->purchasable_type === \App\Models\Product::class) {
                // Create License
                \App\Models\UserLicense::create([
                    'user_id' => $order->user_id,
                    'product_id' => $item->purchasable_id,
                    'license_key' => 'DGTY-LIC-' . strtoupper(\Illuminate\Support\Str::random(16)),
                    'status' => 'active',
                    'activated_at' => now(),
                ]);
            } else if ($item->purchasable_type === \App\Models\Course::class) {
                // Create Enrollment
                \App\Models\Enrollment::create([
                    'user_id' => $order->user_id,
                    'course_id' => $item->purchasable_id,
                    'enrolled_at' => now(),
                    'status' => 'active',
                ]);
            }
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Payment status updated'
    ]);
});

Route::get('/payment/mock-payment', function (Request $request) {
    $orderNumber = $request->query('order');
    $order = \App\Models\Order::where('order_number', $orderNumber)->first();

    if (!$order) {
        return "Order tidak ditemukan.";
    }

    if ($order->payment_status !== 'paid') {
        $order->payment_status = 'paid';
        $order->status = 'completed';
        $order->save();

        // Process purchased items
        $items = \App\Models\OrderItem::where('order_id', $order->id)->get();
        foreach ($items as $item) {
            if ($item->purchasable_type === \App\Models\Product::class) {
                // Create License
                \App\Models\UserLicense::create([
                    'user_id' => $order->user_id,
                    'product_id' => $item->purchasable_id,
                    'license_key' => 'DGTY-LIC-' . strtoupper(\Illuminate\Support\Str::random(16)),
                    'status' => 'active',
                    'activated_at' => now(),
                ]);
            } else if ($item->purchasable_type === \App\Models\Course::class) {
                // Create Enrollment
                \App\Models\Enrollment::create([
                    'user_id' => $order->user_id,
                    'course_id' => $item->purchasable_id,
                    'enrolled_at' => now(),
                    'status' => 'active',
                ]);
            }
        }
    }

    // Redirect user back to frontend dashboard
    $frontendUrl = env('NEXT_PUBLIC_SITE_URL', 'http://localhost:3000');
    return redirect()->away($frontendUrl . '/dashboard/orders?payment=success');
});

// ==========================================
// DYNAMIC SEO & REDIRECT ENDPOINTS (CMS-5.1)
// ==========================================

Route::get('/seo/sitemap', function () {
    $urls = [];

    // Static pages
    $staticPages = ['home', 'about', 'contact', 'solutions', 'insights', 'job-connect', 'products', 'academy'];
    foreach ($staticPages as $page) {
        $path = $page === 'home' ? '/' : "/{$page}";
        $urls[] = [
            'loc' => $path,
            'lastmod' => now()->startOfDay()->toIso8601String(),
            'changefreq' => 'weekly',
            'priority' => $page === 'home' ? '1.0' : '0.8',
        ];
    }

    // Blogs
    \App\Models\Blog::select('slug', 'updated_at')->get()->each(function ($blog) use (&$urls) {
        $urls[] = [
            'loc' => "/insights/{$blog->slug}",
            'lastmod' => $blog->updated_at->toIso8601String(),
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];
    });

    // Products
    \App\Models\Product::whereRaw('is_active = true')->select('slug', 'updated_at')->get()->each(function ($product) use (&$urls) {
        $urls[] = [
            'loc' => "/products/{$product->slug}",
            'lastmod' => $product->updated_at->toIso8601String(),
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];
    });

    // Courses
    \App\Models\Course::whereRaw('is_active = true')->select('slug', 'updated_at')->get()->each(function ($course) use (&$urls) {
        $urls[] = [
            'loc' => "/academy/{$course->slug}",
            'lastmod' => $course->updated_at->toIso8601String(),
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];
    });

    // Portfolios
    \App\Models\Portfolio::select('slug', 'updated_at')->get()->each(function ($portfolio) use (&$urls) {
        $urls[] = [
            'loc' => "/portfolio/{$portfolio->slug}",
            'lastmod' => $portfolio->updated_at->toIso8601String(),
            'changefreq' => 'weekly',
            'priority' => '0.6',
        ];
    });

    // Services
    \App\Models\Service::select('slug', 'updated_at')->get()->each(function ($service) use (&$urls) {
        $urls[] = [
            'loc' => "/solutions/{$service->slug}",
            'lastmod' => $service->updated_at->toIso8601String(),
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];
    });

    // Careers
    \App\Models\Career::whereRaw('is_active = true')->select('slug', 'updated_at')->get()->each(function ($career) use (&$urls) {
        $urls[] = [
            'loc' => "/job-connect/{$career->slug}",
            'lastmod' => $career->updated_at->toIso8601String(),
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];
    });

    return response()->json([
        'success' => true,
        'urls' => $urls
    ]);
});

Route::get('/seo/redirects', function () {
    $redirects = \App\Models\Redirect::select('from_path', 'to_path', 'status_code')->get();
    return response()->json([
        'success' => true,
        'redirects' => $redirects
    ]);
});

Route::get('/seo/page/{slug}', function ($slug) {
    $seo = \App\Models\StaticPageSeo::where('page_slug', $slug)->first();
    return response()->json([
        'success' => true,
        'seo' => $seo
    ]);
});

Route::post('/analytics/pageview', function (Request $request) {
    $validated = $request->validate([
        'path' => 'required|string|max:255',
        'url' => 'nullable|string|max:2048',
        'referrer' => 'nullable|string|max:2048',
        'userAgent' => 'nullable|string|max:2048',
    ]);

    // Hashing IP for privacy compliance
    $ip = $request->ip();
    $hashedIp = $ip ? hash('sha256', $ip . config('app.key')) : null;

    $pageView = \App\Models\PageView::create([
        'path' => $validated['path'],
        'url' => $validated['url'] ?? null,
        'referrer' => $validated['referrer'] ?? null,
        'ip_address' => $hashedIp,
        'user_agent' => $validated['userAgent'] ?? $request->userAgent(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'PageView tracked successfully',
        'data' => $pageView
    ], 201);
});
