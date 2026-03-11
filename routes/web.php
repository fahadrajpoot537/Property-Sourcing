<?php

use Illuminate\Support\Facades\Route;
use App\Models\Property;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PasswordResetController;

// Public Routes
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

// Temporary Fix for Admin Role (Delete after use)
Route::get('/make-me-admin/{email}', function ($email) {
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        $user->role = 'admin';
        $user->save();
        return "User {$email} is now an admin. You can now access /admin/dashboard";
    }
    return "User not found.";
});
Route::get('/services/{slug}', [FrontController::class, 'service'])->name('service.show');

// About Pages
Route::get('/how-it-works', [FrontController::class, 'howItWorks'])->name('how-it-works');
Route::get('/why-choose-us', [FrontController::class, 'whyChooseUs'])->name('why-choose-us');
Route::get('/meet-the-team', [FrontController::class, 'meetTheTeam'])->name('meet-the-team');

// Podcast
Route::get('/podcast', [FrontController::class, 'podcast'])->name('podcast');
Route::get('/become-property-investor', [FrontController::class, 'becomeInvestor'])->name('become-investor');
Route::get('/investor-event', [FrontController::class, 'investorEvent'])->name('investor-event');
Route::get('/recent-investment-properties', [FrontController::class, 'properties'])->name('properties.index');

// News/Blog Frontend Routes
Route::get('/news', [FrontController::class, 'news'])->name('news.index');
Route::get('/news/{slug}', [FrontController::class, 'newsShow'])->name('news.show');

// Contact & FAQ
Route::get('/contact-us', [FrontController::class, 'contact'])->name('contact');
Route::get('/faq', [FrontController::class, 'faq'])->name('faq');

// Inquiry Submission
Route::post('/inquiry/submit', [InquiryController::class, 'store'])->name('inquiry.submit');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register.submit');

// Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');



// Available Properties (Logged-in Users)
Route::middleware('auth')->group(function () {
    // Unified Messaging System (Shared)
    Route::get('/dashboard/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('admin.messages.index');
    Route::post('/dashboard/messages/fetch', [\App\Http\Controllers\Admin\MessageController::class, 'fetchMessages'])->name('admin.messages.fetch');
    Route::post('/dashboard/messages/send', [\App\Http\Controllers\Admin\MessageController::class, 'sendMessage'])->name('admin.messages.send');

    Route::get('/available-properties', [App\Http\Controllers\AvailablePropertyController::class, 'index'])->name('available-properties.index');
    Route::get('/available-properties/{id}', [App\Http\Controllers\AvailablePropertyController::class, 'show'])->name('available-properties.show');
    Route::get('/available-properties/{id}/brochure', [App\Http\Controllers\AvailablePropertyController::class, 'downloadBrochure'])->name('available-properties.brochure');


    // Property Actions
    Route::post('/property/offer', [App\Http\Controllers\PropertyOfferController::class, 'store'])->name('property.offer.store');
    Route::post('/property/favorite/{property}', [App\Http\Controllers\PropertyFavoriteController::class, 'toggle'])->name('property.favorite.toggle');
    Route::post('/property/message', [App\Http\Controllers\PropertyMessageController::class, 'store'])->name('property.message.store');

    // User Dashboard
    Route::get('/dashboard', [App\Http\Controllers\UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/credits', [App\Http\Controllers\UserDashboardController::class, 'credits'])->name('user.credits.index');

    // User lists
    Route::get('/my-offers', [App\Http\Controllers\PropertyOfferController::class, 'index'])->name('user.offers.index');
    Route::get('/my-favorites', [App\Http\Controllers\PropertyFavoriteController::class, 'index'])->name('user.favorites.index');
    Route::get('/my-messages', [App\Http\Controllers\PropertyMessageController::class, 'index'])->name('user.messages.index');

    // Profile
    Route::get('/profile/edit', [App\Http\Controllers\UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\UserProfileController::class, 'update'])->name('user.profile.update');
});

// Admin & Agent Shared Staff Routes
Route::prefix('admin')->middleware(['auth', 'agent'])->name('admin.')->group(function () {
    Route::get('/dashboard', [PropertyController::class, 'dashboard'])->name('dashboard');


    // Available Properties Management
    Route::get('/available-properties', [App\Http\Controllers\AvailablePropertyController::class, 'adminIndex'])->name('available-properties.index');
    Route::get('/available-properties/create', [App\Http\Controllers\AvailablePropertyController::class, 'create'])->name('available-properties.create');
    Route::post('/available-properties', [App\Http\Controllers\AvailablePropertyController::class, 'store'])->name('available-properties.store');
    Route::get('/available-properties/{id}/edit', [App\Http\Controllers\AvailablePropertyController::class, 'edit'])->name('available-properties.edit');
    Route::put('/available-properties/{id}', [App\Http\Controllers\AvailablePropertyController::class, 'update'])->name('available-properties.update');
    Route::post('/available-properties/{id}/status', [App\Http\Controllers\AvailablePropertyController::class, 'updateStatus'])->name('available-properties.update-status');
    Route::delete('/available-properties/{id}', [App\Http\Controllers\AvailablePropertyController::class, 'destroy'])->name('available-properties.destroy');
    Route::post('/available-properties/send-bulk-email', [App\Http\Controllers\AvailablePropertyController::class, 'sendBulkEmail'])->name('available-properties.send-bulk-email');
    Route::post('/available-properties/{id}/notify-agents', [App\Http\Controllers\AvailablePropertyController::class, 'notifyAgents'])->name('available-properties.notify-agents');
    Route::get('/available-properties/{id}/insta-post', [App\Http\Controllers\AvailablePropertyController::class, 'instaPost'])->name('available-properties.insta-post');

    // Inquiry Management
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{id}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::delete('/inquiries/{id}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');
    Route::post('/inquiries/{id}/mark-read', [InquiryController::class, 'markAsRead'])->name('inquiries.mark-read');
    Route::post('/inquiries/{id}/mark-unread', [InquiryController::class, 'markAsUnread'])->name('inquiries.mark-unread');

    // Property Offers & Completion (Shared: Admin & Agent)
    Route::get('/property-offers', [\App\Http\Controllers\Admin\PropertyOfferController::class, 'all'])->name('property-offers.all');
    Route::get('/property/{property}/offers', [\App\Http\Controllers\Admin\PropertyOfferController::class, 'index'])->name('property-offers.index');
    Route::put('/offers/{offer}', [\App\Http\Controllers\Admin\PropertyOfferController::class, 'update'])->name('property-offers.update');
    Route::post('/offers/{offer}/complete', [\App\Http\Controllers\Admin\PropertyOfferController::class, 'complete'])->name('property-offers.complete');

    // Investor Management (Shared: Admin & Agent)
    Route::post('investors/import', [\App\Http\Controllers\Admin\InvestorController::class, 'import'])->name('investors.import');
    Route::get('investors/template', [\App\Http\Controllers\Admin\InvestorController::class, 'downloadTemplate'])->name('investors.template');
    Route::resource('investors', \App\Http\Controllers\Admin\InvestorController::class);

    // Admin-Only Routes
    Route::middleware('admin')->group(function () {
        Route::get('/agent-properties', [App\Http\Controllers\AvailablePropertyController::class, 'agentProperties'])->name('agent-properties');

        // Property Management (Manual / Sold Portfolio)
        Route::get('/portfolio', [PropertyController::class, 'index'])->name('portfolio');
        Route::get('/create', [PropertyController::class, 'create'])->name('create');

        Route::post('/store', [PropertyController::class, 'store'])->name('store');
        Route::get('/edit/{property}', [PropertyController::class, 'edit'])->name('edit');
        Route::delete('/destroy/{property}', [PropertyController::class, 'destroy'])->name('destroy');
        Route::put('/update/{property}', [PropertyController::class, 'update'])->name('update');

        // Service Management using Resource Controller
        Route::resource('services', ServiceController::class);

        // Location Management
        Route::resource('locations', \App\Http\Controllers\LocationController::class);

        // Team Member Management
        Route::resource('team', \App\Http\Controllers\TeamMemberController::class);

        // Blog/News Management
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);

        // FAQ Management
        Route::resource('faq', \App\Http\Controllers\Admin\FaqController::class)->names([
            'index' => 'faq.index',
            'create' => 'faq.create',
            'store' => 'faq.store',
            'edit' => 'faq.edit',
            'update' => 'faq.update',
            'destroy' => 'faq.destroy',
        ]);

        // Work Step Management
        Route::resource('work-steps', \App\Http\Controllers\Admin\WorkStepController::class)->names([
            'index' => 'work-steps.index',
            'create' => 'work-steps.create',
            'store' => 'work-steps.store',
            'edit' => 'work-steps.edit',
            'update' => 'work-steps.update',
            'destroy' => 'work-steps.destroy',
        ]);

        // User Management
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/status', [\App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('users.status');
        Route::post('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.role');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Metadata Management
        Route::resource('property-types', \App\Http\Controllers\Admin\PropertyTypeController::class);
        Route::resource('marketing-purposes', \App\Http\Controllers\Admin\MarketingPurposeController::class);
        Route::resource('unit-types', \App\Http\Controllers\Admin\UnitTypeController::class);
        Route::resource('features', \App\Http\Controllers\Admin\FeatureController::class);
        Route::resource('trustpilot-reviews', \App\Http\Controllers\Admin\TrustpilotReviewController::class)
            ->names([
                'index' => 'trustpilot-reviews.index',
                'create' => 'trustpilot-reviews.create',
                'store' => 'trustpilot-reviews.store',
                'edit' => 'trustpilot-reviews.edit',
                'update' => 'trustpilot-reviews.update',
                'destroy' => 'trustpilot-reviews.destroy',
            ])
            ->parameters(['trustpilot-reviews' => 'trustpilot_review']);



    });
});

// Location Frontend Routes
Route::get('/locations', [FrontController::class, 'locations'])->name('locations.index');
Route::get('/locations/{slug}', [FrontController::class, 'location'])->name('location.show');

// News/Blog Frontend Routes
Route::get('/news', [FrontController::class, 'news'])->name('news.index');
Route::get('/news/{slug}', [FrontController::class, 'newsShow'])->name('news.show');
