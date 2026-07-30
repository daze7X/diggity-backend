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
        'instagram_url' => 'https://instagram.com',
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

    $services = Service::with('category')
        ->where('name', 'like', "%{$query}%")
        ->orWhere('description', 'like', "%{$query}%")
        ->limit(5)
        ->get();

    $portfolios = Portfolio::with('category')
        ->where('title', 'like', "%{$query}%")
        ->orWhere('problem', 'like', "%{$query}%")
        ->orWhere('solution', 'like', "%{$query}%")
        ->limit(5)
        ->get();

    $blogs = Blog::with('category')
        ->where('title', 'like', "%{$query}%")
        ->orWhere('content', 'like', "%{$query}%")
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

    // Store CV PDF in 'public/cvs'
    $cvPath = $request->file('cv')->store('cvs', 'public');

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
