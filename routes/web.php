<?php

use App\Http\Controllers\ConsultationRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFileController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsultationAnswerController;

Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/consultation-requests', [ConsultationRequestController::class, 'indexByUser'])->name('consultation_requests.indexByUser');
Route::get('/consultation-requests/{consultationRequest}', [ConsultationRequestController::class, 'showDocument'])->name('consultation_requests.showDocument');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/dashboard/print', [DashboardController::class, 'printStatistics'])->name('dashboard.print');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('user_types', UserTypeController::class);
    Route::resource('priorities', PriorityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('consultation_requests', ConsultationRequestController::class);
    Route::resource('consultation_answers', ConsultationAnswerController::class);
    Route::patch('/consultation-requests/{consultationRequest}/accept', [ConsultationRequestController::class, 'accept'])->name('consultation_requests.accept');
    Route::patch('/consultation-requests/{consultationRequest}/reject', [ConsultationRequestController::class, 'reject'])->name('consultation_requests.reject');
    Route::get('/consultation-answers/create/{consultationRequest}', [ConsultationAnswerController::class, 'create'])->name('consultation-answers.create');
//    Route::post('/consultation-answers', [ConsultationAnswerController::class, 'store'])->name('consultation-answers.store');
    Route::resource('users', UserController::class);
    Route::post('/user-files', [UserFileController::class, 'store'])->name('user_files.store');
    Route::get('/user-files/{userFile}/download', [UserFileController::class, 'download'])->name('user_files.download');
    Route::get('/user-files/{userFile}/preview', [UserFileController::class, 'preview'])->name('user_files.preview');

    Route::delete('/user-files/{userFile}', [UserFileController::class, 'destroy'])->name('user_files.destroy');
    Route::get('/consultation-requests/{consultationRequest}/files/{userFile}', [ConsultationRequestController::class, 'showFile'])->name('consultation_requests.files.show');


    Route::resource('workflow', WorkflowController::class);
    Route::patch('/consultation_requests/{consultationRequest}/sendToCommittee', [ConsultationRequestController::class, 'sendToCommittee'])->name('consultation_requests.sendToCommittee');
    Route::patch('/consultation_requests/{consultationRequest}/finish', [ConsultationRequestController::class, 'finish'])->name('consultation_requests.finish');
//    Route::patch('/consultation_requests/{consultationRequest}/reject', [ConsultationRequestController::class, 'reject'])->name('consultation_requests.reject');
    
    // Document routes
    Route::get('/documents/export', [DocumentController::class, 'export'])->name('documents.export');
    Route::get('/documents/export-excel', [DocumentController::class, 'exportExcel'])->name('documents.export-excel');
    Route::get('/documents/import-form', [DocumentController::class, 'importForm'])->name('documents.import-form');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::resource('documents', DocumentController::class);
    
    // Document Type routes
    Route::resource('document-types', DocumentTypeController::class);

    // Routes pour l'importation de documents
    Route::get('documents/import', [App\Http\Controllers\DocumentController::class, 'importForm'])->name('documents.import.form');
    Route::post('documents/process-import', [App\Http\Controllers\DocumentController::class, 'processImport'])->name('documents.process-import');
    Route::post('documents/import-documents', [App\Http\Controllers\DocumentController::class, 'importDocuments'])->name('documents.import-documents');
});

require __DIR__.'/auth.php';
