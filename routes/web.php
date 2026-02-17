<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\AboutWebController;
use App\Http\Controllers\AdminUsaha\AdminUDashboardController;
use App\Http\Controllers\MitraUsahaController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UsahaVerificationController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\CarouselController;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use App\Http\Controllers\FCMController;


Route::middleware('block.role:superadmin,admin_usaha')->group(function () {
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lamaran', [HomeController::class, 'lamaranSaya'])->name('lamaran');
Route::get('/lamaran/{id}', [HomeController::class, 'lamaranDetail'])->name('lamaranDetail');
Route::get('/user-lamaran/{id}/json-detail', 
    [HomeController::class, 'lamaranDetailJson'])
    ->name('user.lamaran.json');

Route::get('/articles', [ArticleController::class, 'publicIndex'])->name('public.articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'publicShow'])->name('public.articles.show');
Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');   
Route::get('/lowonganAll', [HomeController::class, 'lowonganAll'])->name('lowonganAll');   

});



// AUTH
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/register-usaha', [MitraUsahaController::class, 'store'])
    ->name('register.usaha');
    Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendReset'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetUpdate'])->name('password.update');

});


Route::middleware('auth')->group(function () {

    Route::post('/pelamar/update-profil',
        [HomeController::class, 'updateProfilPelamar']
    )->name('pelamar.updateProfil');

    Route::get('/applyNow/{id}',
        [HomeController::class, 'applyLamaran']
    )->name('applyNow');

    Route::post('/lamar/{lowongan}',
        [LamaranController::class, 'store']
    )->name('lamaran.store');
    Route::get('/lamaran/{id}/detail-json',
        [LamaranController::class, 'detailJson']
    )->name('lamaran.detailJson');
});


//INDO REGION UNTUK MAP
Route::get('/provinces', function () {
    return Province::orderBy('name')->get();
});
Route::get('/cities/{province_code}', function ($province_code) {
    return City::where('province_code', $province_code)
        ->orderBy('name')
        ->get();
});
Route::get('/districts/{city_code}', function ($city_code) {
    return District::where('city_code', $city_code)
        ->orderBy('name')
        ->get();
});
Route::get('/villages/{district_code}', function ($district_code) {
    return Village::where('district_code', $district_code)
        ->orderBy('name')
        ->get();
});


Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

    Route::get('/dashboard',[DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/profile',[DashboardController::class, 'profile'])
        ->name('profile');
    Route::put('/profile/update', [DashboardController::class, 'update'])->name('profile.update');

    // ===== VERIFIKASI USAHA =====
    Route::get('/usaha', [UsahaVerificationController::class, 'index'])
        ->name('usaha.index');

    Route::get('/usaha/{id}', [UsahaVerificationController::class, 'show'])
        ->name('usaha.show');

    Route::post('/usaha/{id}/approve', [UsahaVerificationController::class, 'approve'])
        ->name('usaha.approve');

    Route::post('/usaha/{id}/reject', [UsahaVerificationController::class, 'reject'])
        ->name('usaha.reject');
    //mitra
    
});

Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::resource('mitra', MitraController::class)->except([]);
});


Route::middleware(['auth', 'role:admin_usaha'])
    ->prefix('admin_usaha')
    ->name('admin_usaha.')
    ->group(function () {
        Route::get('/dashboard', [AdminUDashboardController::class,'index'])->name('dashboard');
        Route::resource('lowongan', LowonganController::class);
        Route::get('/lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
        Route::get('/lamaran/{id}', [LamaranController::class, 'show'])->name('lamaran.show');
        Route::post('/lamaran/{id}/update-status', [LamaranController::class, 'updateStatus'])
            ->name('lamaran.updateStatus');
        Route::post('/lamaran/{id}/send-notif', [LamaranController::class, 'sendNotif'])
            ->name('lamaran.sendNotif');
        Route::get('/show', [MitraUsahaController::class, 'show'])->name('show');
        Route::get('/profile', [MitraUsahaController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [MitraUsahaController::class, 'updateProfile'])->name('profile.update');
    });



// Route Superadmin Lowongan
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/lowongan', [LowonganController::class, 'indexSuperadmin'])->name('lowongan.index');
        Route::post('/lowongan/{id}/status', [LowonganController::class, 'updateStatusSuperadmin'])->name('lowongan.updateStatus');
        Route::get('/lowongan/create', [LowonganController::class, 'createSuperadmin'])->name('lowongan.create');
        Route::post('/lowongan', [LowonganController::class, 'storeSuperadmin'])->name('lowongan.store');
        Route::get('/lowongan/{id}', [LowonganController::class, 'showSuperadmin'])->name('lowongan.show');
        Route::get('/lowongan/{id}/edit', [LowonganController::class, 'editSuperadmin'])->name('lowongan.edit');
        Route::put('/lowongan/{id}', [LowonganController::class, 'updateSuperadmin'])->name('lowongan.update');
    });


Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback']);    
Route::get('/dashboard', [HomeController::class, 'loginComplete'])
    ->middleware('auth')
    ->name('dashboard');
Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify.form');
Route::post('/verify', [AuthController::class, 'verifyCode'])->name('verify.code');



    
// SUPERADMIN FAQ
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::resource('faqs', FAQController::class)->except(['show']);
});

// SUPERADMIN ARTIKEL
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::resource('articles', ArticleController::class)->except([]);
});
// SUPERADMIN USER
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::resource('users', UserController::class)->except([]);
    Route::get('/mitra-usaha/{id}', [UserController::class, 'getMitra']);
});

Route::middleware(['auth'])->group(function() {
    Route::post('/article/{id}/like', [ArticleController::class, 'toggleLike'])->name('article.like');
    Route::post('/article/{id}/bookmark', [ArticleController::class, 'toggleBookmark'])->name('article.bookmark');
});

//KHUSUS ANU LOGIN ARTIKEL
Route::middleware(['auth'])->group(function () {
    Route::get('/my/likes', [ArticleController::class, 'myLikes'])
        ->name('public.articles.myLikes');

    Route::get('/my/bookmarks', [ArticleController::class, 'myBookmarks'])
        ->name('public.articles.myBookmarks');
});


Route::get('/test-firebase', function () {
    return [
        'project' => env('FIREBASE_PROJECT_ID'),
        'email' => env('FIREBASE_CLIENT_EMAIL'),
        'key' => substr(env('FIREBASE_PRIVATE_KEY'), 0, 30)
    ];
});






/* =======================
| PUBLIC
======================= */
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/* =======================
| ADMIN
======================= */
Route::prefix('superadmin')
    ->middleware(['auth', 'role:superadmin'])
    ->group(function () {

    Route::get('/contacts', [ContactController::class, 'adminIndex'])
        ->name('superadmin.contacts.index');

    Route::get('/contacts/{contact}', [ContactController::class, 'show'])
        ->name('superadmin.contacts.show');

    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])
        ->name('superadmin.contacts.destroy');
});


// PUBLIC
Route::get('/about', [AboutWebController::class, 'show'])->name('about.index');

// SUPERADMIN
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/about', [AboutWebController::class, 'index'])->name('about.index');
        Route::get('/about/edit', [AboutWebController::class, 'edit'])->name('about.edit');
        Route::put('/about/update', [AboutWebController::class, 'update'])->name('about.update');
        
       // Carousel Routes
        Route::get('/carousel', [CarouselController::class, 'index'])->name('carousel.index');
        Route::get('/carousel/create', [CarouselController::class, 'create'])->name('carousel.create');
        Route::post('/carousel', [CarouselController::class, 'store'])->name('carousel.store');
        Route::get('/carousel/{id}/edit', [CarouselController::class, 'edit'])->name('carousel.edit');
        Route::put('/carousel/{id}', [CarouselController::class, 'update'])->name('carousel.update');
        Route::delete('/carousel/{id}', [CarouselController::class, 'destroy'])->name('carousel.destroy');

        

    });

   