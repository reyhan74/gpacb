<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateAdminController;
use App\Http\Controllers\CandidateTopicAdminController;
use App\Http\Controllers\CandidatePortalController;
use App\Http\Controllers\CandidateRegistrationController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MemberAdminController;
use App\Http\Controllers\MemberPortalController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\SiteSettingsController;
use Illuminate\Support\Facades\Route;

// --- HALAMAN PUBLIK & CEK NIA ---
Route::get('/', [PublicSiteController::class, 'home'])->name('home');
Route::get('/cek-nia', [PublicSiteController::class, 'checkNia'])->name('public.check-nia');
Route::get('/pendaftaran-calon-anggota', [CandidateRegistrationController::class, 'create'])->name('public.candidates.create');
Route::post('/pendaftaran-calon-anggota', [CandidateRegistrationController::class, 'store'])->name('public.candidates.store');
Route::get('/pendaftaran-calon-anggota/status', [CandidateRegistrationController::class, 'status'])->name('public.candidates.status');
Route::get('/app-logo', [SiteSettingsController::class, 'logo'])->name('app.logo');
Route::get('/kegiatan', [PublicSiteController::class, 'articles'])->name('public.articles');
Route::get('/kegiatan/{slug}', [PublicSiteController::class, 'showArticle'])->name('public.article.show');

// --- AUTENTIKASI ---
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

// --- AREA LOGIN (AUTH) ---
Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // Portal Calon Anggota
    Route::prefix('candidate')->name('candidate.')->middleware('role:calon')->group(function (): void {
        Route::get('/dashboard', [CandidatePortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [CandidatePortalController::class, 'profile'])->name('profile');
        Route::put('/profile', [CandidatePortalController::class, 'updateProfile'])->name('profile.update');
        Route::get('/weekly-log', [CandidatePortalController::class, 'weeklyLog'])->name('weekly-log');
        Route::post('/weekly-log', [CandidatePortalController::class, 'storeLog'])->name('weekly-log.store');
        Route::get('/agenda', [CandidatePortalController::class, 'agenda'])->name('agenda');
    });

    // Portal Mandiri Anggota
    Route::prefix('member')->name('member.')->middleware('role:anggota')->group(function (): void {
        Route::get('/dashboard', [MemberPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/kta', [MemberPortalController::class, 'previewKta'])->name('kta.preview');
        Route::get('/kta-download', [MemberPortalController::class, 'downloadKta'])->name('kta.download');
        Route::get('/profile', [MemberPortalController::class, 'editProfile'])->name('profile');
        Route::put('/profile', [MemberPortalController::class, 'updateProfile'])->name('profile.update');
        Route::get('/change-password', [MemberPortalController::class, 'changePasswordForm'])->name('password.change');
        Route::post('/change-password', [MemberPortalController::class, 'updatePassword'])->name('password.update');
        Route::get('/contents', [ContentController::class, 'memberIndex'])->name('contents.index');
        Route::get('/contents/create', [ContentController::class, 'memberCreate'])->name('contents.create');
        Route::post('/contents', [ContentController::class, 'memberStore'])->name('contents.store');
    });

    // Panel Pengurus & Superadmin
    Route::prefix('manage')->name('manage.')->middleware('role:superadmin,admin,documentation')->group(function (): void {
        Route::get('/', [ManagementController::class, 'index'])->name('dashboard');

        // Calon Anggota: daftar -> pematerian -> Diklat Ruang -> Diklat SAR -> NIA
        Route::get('/candidates', [CandidateAdminController::class, 'index'])->name('candidates.index');
        Route::get('/candidates/{candidate}', [CandidateAdminController::class, 'show'])->name('candidates.show');
        Route::patch('/candidates/{candidate}/stage', [CandidateAdminController::class, 'stage'])->name('candidates.stage');
        Route::patch('/candidates/{candidate}/reject', [CandidateAdminController::class, 'reject'])->name('candidates.reject');
        Route::patch('/candidates/{candidate}/issue-nia', [CandidateAdminController::class, 'issueNia'])->name('candidates.issue-nia');
        Route::get('/candidate-topics', [CandidateTopicAdminController::class, 'index'])->name('candidate-topics.index');
        Route::post('/candidate-topics', [CandidateTopicAdminController::class, 'store'])->name('candidate-topics.store');
        Route::delete('/candidate-topics/{topic}', [CandidateTopicAdminController::class, 'destroy'])->name('candidate-topics.destroy');

        // Manajemen Anggota & NIA
        Route::get('/members', [MemberAdminController::class, 'index'])->name('members.index');
        Route::get('/members/create', [MemberAdminController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberAdminController::class, 'store'])->name('members.store');
        Route::get('/members/{member}/edit', [MemberAdminController::class, 'edit'])->name('members.edit');
        Route::put('/members/{member}', [MemberAdminController::class, 'update'])->name('members.update');
        Route::delete('/members/{member}', [MemberAdminController::class, 'destroy'])->name('members.destroy');
        Route::post('/members/import-csv', [MemberAdminController::class, 'importCsv'])->name('members.import-csv');
        Route::get('/members/import-template', [MemberAdminController::class, 'downloadImportTemplate'])->name('members.import-template');
        Route::get('/members/{member}/kta', [MemberAdminController::class, 'previewKta'])->name('members.kta');
        Route::get('/members/{member}/kta-download', [MemberAdminController::class, 'downloadKta'])->name('members.kta.download');

        // CMS Konten Kegiatan & Artikel
        Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
        Route::get('/contents/create', [ContentController::class, 'create'])->name('contents.create');
        Route::post('/contents', [ContentController::class, 'store'])->name('contents.store');
        Route::get('/contents/{content}/edit', [ContentController::class, 'edit'])->name('contents.edit');
        Route::put('/contents/{content}', [ContentController::class, 'update'])->name('contents.update');
        Route::delete('/contents/{content}', [ContentController::class, 'destroy'])->name('contents.destroy');

        // Pengaturan Sistem & Superadmin
        Route::get('/users', [ManagementController::class, 'users'])->name('users');
        Route::get('/documentation-admin', [ManagementController::class, 'documentationAdmin'])->name('documentation-admin');
        Route::post('/documentation-admin', [ManagementController::class, 'updateDocumentationAdmin'])->name('documentation-admin.update');
        Route::patch('/contents/{content}/approve', [ContentController::class, 'approve'])->name('contents.approve');
        Route::get('/settings', [SiteSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SiteSettingsController::class, 'update'])->name('settings.update');
    });
});
