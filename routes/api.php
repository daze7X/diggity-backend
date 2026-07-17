<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

// GET /api/portfolios
Route::get('/portfolios', function () {
    return response()->json(Portfolio::with('category')->latest()->get());
});

// GET /api/portfolios/{slug}
Route::get('/portfolios/{slug}', function ($slug) {
    $portfolio = Portfolio::with('category')->where('slug', $slug)->firstOrFail();
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
    return response()->json(Career::where('is_active', true)->latest()->get());
});

// GET /api/careers/{slug}
Route::get('/careers/{slug}', function ($slug) {
    $career = Career::where('slug', $slug)->firstOrFail();
    return response()->json($career);
});

// POST /api/leads
Route::post('/leads', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:50',
        'company' => 'nullable|string|max:255',
        'service' => 'nullable|string|max:255',
        'message' => 'required|string',
    ]);

    $lead = Lead::create($validated);
    return response()->json([
        'success' => true,
        'message' => 'Lead submitted successfully',
        'data' => $lead
    ], 201);
});

// POST /api/subscribers
Route::post('/subscribers', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|unique:subscribers,email|max:255',
    ]);

    $subscriber = Subscriber::create([
        'email' => $validated['email'],
        'status' => 'active'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Subscribed successfully',
        'data' => $subscriber
    ], 201);
});

// POST /api/job-applications
Route::post('/job-applications', function (Request $request) {
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

    return response()->json([
        'success' => true,
        'message' => 'Application submitted successfully',
        'data' => $application
    ], 201);
});
