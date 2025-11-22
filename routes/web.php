<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\StoryManagementController;

// Home Page
Route::get('/', [StoryController::class, 'home'])->name('index');

// Authentication Routes
Route::get('/login', function () {
    return view('website.auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('website.auth.signup');
})->name('signup');

// Authentication API Routes
Route::post('/api/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/api/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/api/logout', [AuthController::class, 'logout'])->name('api.logout');
Route::get('/api/user', [AuthController::class, 'user'])->name('api.user');

// Profile Management API Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/api/profile/update', [AuthController::class, 'updateProfile'])->name('api.profile.update');
    Route::post('/api/password/update', [AuthController::class, 'updatePassword'])->name('api.password.update');
    Route::post('/api/account/delete', [AuthController::class, 'deleteAccount'])->name('api.account.delete');
    Route::delete('/api/stories/{story}', [AuthController::class, 'deleteStory'])->name('api.story.delete');
});

// Protected User Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        $user = auth()->user();
        $stories = $user->stories()
            ->with(['deleteRequest', 'latestDeleteRequest'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('website.pages.profile', compact('user', 'stories'));
    })->name('profile');

    Route::get('/settings', function () {
        return view('website.pages.settings');
    })->name('settings');

    // User Story Management
    Route::get('/my-stories', [StoryController::class, 'myStories'])->name('stories.my');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
});

// Main Pages
Route::get('/share', [StoryController::class, 'create'])->name('share');
Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');

Route::get('/donate', function () {
    return view('website.pages.donate');
})->name('donate');

// Payment Routes
Route::post('/paypal/payment', [App\Http\Controllers\PayPalController::class, 'processPayment'])->name('paypal.payment');
Route::get('/paypal/success', [App\Http\Controllers\PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [App\Http\Controllers\PayPalController::class, 'cancel'])->name('paypal.cancel');

Route::get('/donation/success/{donation}', function (App\Models\Donation $donation) {
    return view('website.pages.donation-success', compact('donation'));
})->name('donation.success');

Route::get('/donation/failed', function () {
    return view('website.pages.donation-failed');
})->name('donation.failed');

// Public Story Routes
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/see-all', [StoryController::class, 'index'])->name('seeall'); // Alias for stories index
Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');

// Small Screen Pages
Route::get('/stories/small', function () {
    return view('website.pages.stories-small');
})->name('stories.small');

Route::get('/about/small', function () {
    return view('website.pages.about-small');
})->name('about.small');

Route::get('/contact/small', function () {
    return view('website.pages.contact-small');
})->name('contact.small');

// Story Slider Pages (keep these for now if they're still being used)
Route::get('/stories/slider/one', function () {
    return view('website.pages.stories-slider-one');
})->name('stories.slider.one');

Route::get('/stories/slider/two', function () {
    return view('website.pages.stories-slider-two');
})->name('stories.slider.two');

Route::get('/stories/slider/three', function () {
    return view('website.pages.stories-slider-three');
})->name('stories.slider.three');

// ========================================
// Dashboard Routes
// ========================================

// Dashboard Auth Routes (Public)
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/login', [DashboardController::class, 'showLogin'])->name('login');
    Route::post('/login', [DashboardController::class, 'login'])->name('login.submit');
});

// Dashboard Protected Routes (Admin Only)
Route::prefix('dashboard')->name('dashboard.')->middleware(['admin'])->group(function () {
    // Dashboard Home
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

    // Story Management
    Route::prefix('stories')->name('stories.')->group(function () {
        Route::get('/', [StoryManagementController::class, 'index'])->name('index');
        Route::get('/create', [StoryManagementController::class, 'create'])->name('create');
        Route::post('/', [StoryManagementController::class, 'store'])->name('store');
        Route::get('/{story}', [StoryManagementController::class, 'show'])->name('show');
        Route::get('/{story}/edit', [StoryManagementController::class, 'edit'])->name('edit');
        Route::put('/{story}', [StoryManagementController::class, 'update'])->name('update');
        Route::post('/{story}/approve', [StoryManagementController::class, 'approve'])->name('approve');
        Route::post('/{story}/reject', [StoryManagementController::class, 'reject'])->name('reject');
        Route::post('/{story}/update-status', [StoryManagementController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{story}', [StoryManagementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('highlights')->name('highlights.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\HighlightManagementController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Dashboard\HighlightManagementController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Dashboard\HighlightManagementController::class, 'store'])->name('store');
        Route::get('/{highlight}/edit', [\App\Http\Controllers\Dashboard\HighlightManagementController::class, 'edit'])->name('edit');
        Route::put('/{highlight}', [\App\Http\Controllers\Dashboard\HighlightManagementController::class, 'update'])->name('update');
        Route::post('/{highlight}/toggle-status', [\App\Http\Controllers\Dashboard\HighlightManagementController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{highlight}', [\App\Http\Controllers\Dashboard\HighlightManagementController::class, 'destroy'])->name('destroy');
    });

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\ProfileController::class, 'index'])->name('index');
        Route::put('/update', [\App\Http\Controllers\Dashboard\ProfileController::class, 'update'])->name('update');
        Route::put('/password', [\App\Http\Controllers\Dashboard\ProfileController::class, 'updatePassword'])->name('password');
    });

    // Admin Management
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\AdminManagementController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Dashboard\AdminManagementController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Dashboard\AdminManagementController::class, 'store'])->name('store');
        Route::get('/{admin}', [\App\Http\Controllers\Dashboard\AdminManagementController::class, 'show'])->name('show');
        Route::get('/{admin}/edit', [\App\Http\Controllers\Dashboard\AdminManagementController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [\App\Http\Controllers\Dashboard\AdminManagementController::class, 'update'])->name('update');
        Route::delete('/{admin}', [\App\Http\Controllers\Dashboard\AdminManagementController::class, 'destroy'])->name('destroy');
    });

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\UserManagementController::class, 'index'])->name('index');
        Route::get('/{user}', [\App\Http\Controllers\Dashboard\UserManagementController::class, 'show'])->name('show');
        Route::delete('/{user}', [\App\Http\Controllers\Dashboard\UserManagementController::class, 'destroy'])->name('destroy');
    });

    // Delete Request Management
    Route::prefix('delete-requests')->name('delete-requests.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\DeleteRequestManagementController::class, 'index'])->name('index');
        Route::get('/{deleteRequest}', [\App\Http\Controllers\Dashboard\DeleteRequestManagementController::class, 'show'])->name('show');
        Route::post('/{deleteRequest}/approve', [\App\Http\Controllers\Dashboard\DeleteRequestManagementController::class, 'approve'])->name('approve');
        Route::post('/{deleteRequest}/reject', [\App\Http\Controllers\Dashboard\DeleteRequestManagementController::class, 'reject'])->name('reject');
    });

    // Donation Management
    Route::prefix('donations')->name('donations.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\DonationManagementController::class, 'index'])->name('index');
        Route::get('/export', [\App\Http\Controllers\Dashboard\DonationManagementController::class, 'export'])->name('export');
        Route::get('/{donation}', [\App\Http\Controllers\Dashboard\DonationManagementController::class, 'show'])->name('show');
    });
});

