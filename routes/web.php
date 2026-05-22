<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Route;

Route::get('/fix-template', function () {
  $html = '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Georgia, serif; background: #1a3a5c; padding: 20px; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
.page { width: 100%; max-width: 900px; background: #1a3a5c; padding: 12px; }
.inner { background: white; border: 2px solid #c9a84c; padding: 40px 60px; text-align: center; }
.college { font-size: 11px; letter-spacing: 4px; color: #1a3a5c; text-transform: uppercase; margin-bottom: 5px; }
.divider { border-top: 1px solid #c9a84c; margin: 8px auto; width: 60%; }
.title { font-size: 48px; color: #c9a84c; font-weight: bold; margin: 5px 0; }
.sub { font-size: 10px; letter-spacing: 5px; color: #888; text-transform: uppercase; margin-bottom: 15px; }
.to { font-size: 11px; color: #999; margin-bottom: 5px; font-style: italic; }
.name { font-size: 36px; color: #1a3a5c; font-weight: bold; margin-bottom: 5px; border-bottom: 2px solid #c9a84c; padding-bottom: 5px; display: inline-block; }
.body { font-size: 11px; color: #555; line-height: 2; margin: 15px 0 25px; }
.body strong { color: #1a3a5c; }
.sig-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.sig-table td { width: 50%; text-align: center; padding: 0 40px; vertical-align: bottom; }
.sig-line { border-top: 1px solid #aaa; padding-top: 5px; font-size: 10px; color: #333; display: inline-block; width: 180px; }
.bottom { margin-top: 20px; border-top: 1px dashed #ddd; padding-top: 8px; display: flex; justify-content: space-between; align-items: center; }
.cert-id { font-size: 7px; color: #bbb; line-height: 1.8; text-align: left; }
</style>
</head>
<body>
<div class="page">
<div class="inner">
  <p class="college">{{college_name}}</p>
  <div class="divider"></div>
  <h1 class="title">Certificate</h1>
  <p class="sub">of {{achievement}}</p>
  <div class="divider"></div>
  <p class="to">This is proudly presented to</p>
  <h2 class="name">{{student_name}}</h2>
  <p class="body">
    Enrollment No: <strong>{{enrollment_number}}</strong> &nbsp;&bull;&nbsp; {{student_branch}} &nbsp;&bull;&nbsp; {{student_year}}<br><br>
    for successfully participating in the<br>
    <strong>{{event_name}}</strong><br>
    held on <strong>{{event_date}}</strong> at {{venue}}
  </p>
  <table class="sig-table">
    <tr>
      <td><div class="sig-line">{{issued_by}}<br><small>{{issuer_designation}}</small></div></td>
      <td><div class="sig-line">Date: {{issued_date}}</div></td>
    </tr>
  </table>
  <div class="bottom">
    <div class="cert-id">Certificate ID: {{certificate_id}}<br>Blockchain Hash: {{block_hash}}</div>
    <div>{{qr_code}}</div>
  </div>
</div>
</div>
</body>
</html>';

  $count = \App\Models\CertificateTemplate::query()->update(['html_content' => $html]);
  return "✅ Updated {$count} templates! Now go to /fix-pdfs";
});

Route::get('/check-template', function () {
  $t = \App\Models\CertificateTemplate::first();
  return response('<pre>' . htmlspecialchars($t->html_content) . '</pre>');
});

Route::get('/preview-cert', function () {
  $cert = \App\Models\Certificate::with(['event', 'issuer', 'template', 'blockchainBlock'])->first();
  if (!$cert)
    return "No certificates found.";
  $template = $cert->template;
  $block = $cert->blockchainBlock;
  $qrHtml = '';
  if ($cert->qr_code_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($cert->qr_code_path)) {
    $qrData = \Illuminate\Support\Facades\Storage::disk('public')->get($cert->qr_code_path);
    $qrB64 = base64_encode($qrData);
    $mime = str_ends_with($cert->qr_code_path, '.svg') ? 'image/svg+xml' : 'image/png';
    $qrHtml = '<img src="data:' . $mime . ';base64,' . $qrB64 . '" width="50" height="50">';
  }
  $rendered = $template->render([
    'student_name' => $cert->student_name,
    'enrollment_number' => $cert->enrollment_number,
    'student_branch' => $cert->student_branch ?? '',
    'student_year' => $cert->student_year ?? '',
    'event_name' => $cert->event->name,
    'event_date' => $cert->event->event_date->format('d M Y'),
    'event_type' => $cert->event->event_type,
    'venue' => $cert->event->venue ?? '',
    'achievement' => $cert->achievement,
    'description' => $cert->description ?? '',
    'issued_date' => $cert->issued_date->format('d M Y'),
    'issued_by' => $cert->issuer->name,
    'issuer_designation' => $cert->issuer->designation ?? '',
    'certificate_id' => $cert->certificate_id,
    'block_hash' => $block ? substr($block->block_hash, 0, 20) . '...' : '',
    'college_name' => config('app.college_name', 'Your College'),
    'qr_code' => $qrHtml,
  ]);
  return response($rendered);
});

Route::get('/fix-pdfs', function () {
  $certs = \App\Models\Certificate::with(['event', 'issuer', 'template', 'blockchainBlock'])->get();
  if ($certs->isEmpty()) {
    return "⚠️ No certificates found.";
  }
  foreach ($certs as $cert) {
    if ($cert->pdf_path) {
      \Illuminate\Support\Facades\Storage::disk('public')->delete($cert->pdf_path);
    }
    if ($cert->qr_code_path) {
      \Illuminate\Support\Facades\Storage::disk('public')->delete($cert->qr_code_path);
    }
    $verifyUrl = route('verify.certificate', ['id' => $cert->certificate_id]);
    $qrFilename = "qrcodes/{$cert->certificate_id}.svg";
    $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
      ->size(150)->errorCorrection('H')->generate($verifyUrl);
    \Illuminate\Support\Facades\Storage::disk('public')->put($qrFilename, $qr);
    $cert->update(['qr_code_path' => $qrFilename]);
    $cert->refresh()->load(['event', 'issuer', 'template', 'blockchainBlock']);
    $certService = app(\App\Services\CertificateService::class);
    $certService->generatePDF($cert);
  }
  return "✅ Regenerated PDFs for {$certs->count()} certificates!";
});

// ── Public: Verification ──────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('verify.index'));
Route::get('/verify', [VerifyController::class, 'index'])->name('verify.index');
Route::post('/verify/search', [VerifyController::class, 'search'])->name('verify.search');
Route::get('/verify/{id}', [VerifyController::class, 'certificate'])->name('verify.certificate');

// ── Auth ──────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('faculty.dashboard');
  Route::get('/profile', [FacultyController::class, 'profile'])->name('faculty.profile');
  Route::post('/profile', [FacultyController::class, 'updateProfile'])->name('faculty.profile.update');
  Route::resource('events', EventController::class)->except(['show']);
  Route::prefix('certificates')->name('certificates.')->group(function () {
    Route::get('/', [CertificateController::class, 'index'])->name('index');
    Route::get('/issue', [CertificateController::class, 'create'])->name('create');
    Route::post('/issue', [CertificateController::class, 'store'])->name('store');
    Route::get('/bulk', [CertificateController::class, 'bulkCreate'])->name('bulk');
    Route::post('/bulk', [CertificateController::class, 'bulkStore'])->name('bulk.store');
    Route::get('/{certificate}', [CertificateController::class, 'show'])->name('show');
    Route::get('/{certificate}/download', [CertificateController::class, 'download'])->name('download');
    Route::post('/{certificate}/email', [CertificateController::class, 'sendEmail'])->name('email');
    Route::post('/{certificate}/revoke', [CertificateController::class, 'revoke'])->name('revoke');
  });
});

// ── Admin Only ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
  Route::get('/blockchain', [AdminController::class, 'blockchain'])->name('blockchain');
  Route::get('/users', [AdminController::class, 'users'])->name('users');
  Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
  Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
  Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
  Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
  Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
  Route::get('/templates', [TemplateController::class, 'index'])->name('templates');
  Route::get('/templates/create', [TemplateController::class, 'create'])->name('templates.create');
  Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
  Route::get('/templates/{template}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
  Route::put('/templates/{template}', [TemplateController::class, 'update'])->name('templates.update');
  Route::get('/templates/{template}/preview', [TemplateController::class, 'preview'])->name('templates.preview');
  Route::delete('/templates/{template}', [TemplateController::class, 'destroy'])->name('templates.delete');
});