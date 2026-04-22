<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Route;

// ── Public: Verification ──────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('verify.index'));
Route::get('/verify',               [VerifyController::class, 'index'])->name('verify.index');
Route::post('/verify/search',       [VerifyController::class, 'search'])->name('verify.search');
Route::get('/verify/{id}',          [VerifyController::class, 'certificate'])->name('verify.certificate');

// ── Auth ──────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated (Faculty / HOD / Coordinator) ───────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Faculty Dashboard & Profile
    Route::get('/dashboard',           [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
    Route::get('/profile',             [FacultyController::class, 'profile'])->name('faculty.profile');
    Route::post('/profile',            [FacultyController::class, 'updateProfile'])->name('faculty.profile.update');

    // Events
    Route::resource('events', EventController::class)->except(['show']);

    // Certificates
    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::get('/',              [CertificateController::class, 'index'])->name('index');
        Route::get('/issue',         [CertificateController::class, 'create'])->name('create');
        Route::post('/issue',        [CertificateController::class, 'store'])->name('store');
        Route::get('/bulk',          [CertificateController::class, 'bulkCreate'])->name('bulk');
        Route::post('/bulk',         [CertificateController::class, 'bulkStore'])->name('bulk.store');
        Route::get('/{certificate}', [CertificateController::class, 'show'])->name('show');
        Route::get('/{certificate}/download', [CertificateController::class, 'download'])->name('download');
        Route::post('/{certificate}/email',   [CertificateController::class, 'sendEmail'])->name('email');
        Route::post('/{certificate}/revoke',  [CertificateController::class, 'revoke'])->name('revoke');
    });
});

// ── Admin Only ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',        [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/blockchain',       [AdminController::class, 'blockchain'])->name('blockchain');

    // Users
    Route::get('/users',            [AdminController::class, 'users'])->name('users');
    Route::get('/users/create',     [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users',           [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit',[AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}',     [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}',  [AdminController::class, 'deleteUser'])->name('users.delete');

    // Templates
    Route::get('/templates',               [TemplateController::class, 'index'])->name('templates');
    Route::get('/templates/create',        [TemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates',              [TemplateController::class, 'store'])->name('templates.store');
    Route::get('/templates/{template}/edit',    [TemplateController::class, 'edit'])->name('templates.edit');
    Route::put('/templates/{template}',         [TemplateController::class, 'update'])->name('templates.update');
    Route::get('/templates/{template}/preview', [TemplateController::class, 'preview'])->name('templates.preview');
    Route::delete('/templates/{template}',      [TemplateController::class, 'destroy'])->name('templates.delete');
});
