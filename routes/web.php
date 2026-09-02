<?php
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminTypeController;
use App\Http\Controllers\Admin\AdminVehicleController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');

// Routes untuk models
Route::get('/models', [ModelController::class, 'index'])->name('models.index');
Route::get('/models/{id}', [ModelController::class, 'show'])->name('models.show');
// Tambahkan route untuk compare (jika diperlukan)
// Route::get('/compare/add/{id}', [CompareController::class, 'add'])->name('compare.add');

// Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
// Route::get('/compare/add/{id}', [CompareController::class, 'add'])->name('compare.add');
// Route::get('/compare/remove/{id}', [CompareController::class, 'remove'])->name('compare.remove');
// Route::get('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');
// Route::get('/compare/result', [CompareController::class, 'compare'])->name('compare.result');
// Route untuk Compare
Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
Route::get('/compare/result', [CompareController::class, 'compare'])->name('compare.result');
// Route::get('/compare/detail/{id}', [CompareController::class, 'compare'])->name('compare.detail');
Route::get('/compare/add/{id}', [CompareController::class, 'add'])->name('compare.add');
Route::get('/compare/remove/{id}', [CompareController::class, 'remove'])->name('compare.remove');
Route::get('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');
Route::get('/compare/detail/{id}', [CompareController::class, 'detail'])->name('compare.detail');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/request-verification', [AuthController::class, 'requestVerification'])->name('request.verification');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verify.code');
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/admin', function() {
//     return view('admin.dashboard');
// })->name('admin.dashboard')->middleware('auth');
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Brand Management
    Route::resource('brands', AdminBrandController::class);
    Route::resource('types', AdminTypeController::class);
    Route::resource('vehicles', AdminVehicleController::class);
});

Route::get('/profile', function () {
    $user = auth()->user();
    return view('profile.index', compact('user'));
})->name('profile.index')->middleware('auth');


Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/check-email', [PasswordResetController::class, 'checkEmail'])->name('password.check');
Route::post('/request-reset', [PasswordResetController::class, 'requestReset'])->name('password.request');
Route::post('/verify-reset-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');



// Route untuk Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update-name', [ProfileController::class, 'updateName'])->name('profile.updateName');
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.uploadPhoto');
    Route::post('/profile/request-reset-code', [ProfileController::class, 'requestResetCode'])->name('profile.requestResetCode');
    Route::post('/profile/verify-reset-code', [ProfileController::class, 'verifyResetCode'])->name('profile.verifyResetCode');
    Route::post('/profile/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');
});
// Route untuk Brand
// Route::get('/', [BrandController::class, 'index'])->name('brands.index');

Route::get('/discussion/{id}', [App\Http\Controllers\DiscussionController::class, 'index'])->name('discussion.index');
Route::post('/discussion/{id}', [App\Http\Controllers\DiscussionController::class, 'store'])->name('discussion.store');
Route::post('/discussion/report', [App\Http\Controllers\DiscussionController::class, 'report'])->name('discussion.report');
Route::delete('/discussion/comment/{id}', [App\Http\Controllers\DiscussionController::class, 'delete'])->name('discussion.delete');


// use App\Http\Controllers\CompareController;
// use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/landing', [LandingController::class, 'index'])->name('landing.index');

// Route untuk Landing AJAX
Route::get('/landing/search', [LandingController::class, 'searchModels'])->name('landing.search');
Route::post('/landing/add', [LandingController::class, 'addToCompare'])->name('landing.add');
Route::post('/landing/remove', [LandingController::class, 'removeFromCompare'])->name('landing.remove');

// Route untuk Compare
Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
Route::get('/compare/result', [CompareController::class, 'compare'])->name('compare.result');
Route::get('/compare/add/{id}', [CompareController::class, 'add'])->name('compare.add');
Route::get('/compare/remove/{id}', [CompareController::class, 'remove'])->name('compare.remove');
Route::get('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

