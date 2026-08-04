<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovingOfficerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\SocialWorkerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'prevent-back', 'can:access-admin')->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', 'index')->name('admin.dashboard');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/admin/users', 'userList')->name('admin.users.list');
        Route::post('/admin/users', 'storeUser')->name('admin.users.store');
        Route::put('/admin/users/{user}', 'update')->name('admin.users.update');
        Route::delete('/admin/users/{user}', 'destroy')->name('admin.users.destroy');
    });

    Route::controller(QueueController::class)->group(function () {
        Route::get('/admin/queue', 'monitor')->name('admin.queue.monitor');
    });

});

Route::middleware('auth', 'prevent-back', 'can:access-receptionist')->group(function () {

    Route::controller(ReceptionistController::class)->group(function () {
        Route::get('/receptionist/dashboard', 'index')->name('receptionist.dashboard');
    });

    Route::controller(ClientController::class)->group(function () {
        Route::get('/receptionist/clients/create', 'create')->name('receptionist.clients.create');
        Route::post('/receptionist/clients', 'store')->name('receptionist.clients.store');
    });

    Route::controller(ValidationController::class)->group(function () {
        Route::get('/receptionist/validation', 'index')->name('receptionist.validation');
        Route::post('/receptionist/validation/{clientProcessing}/proceed', 'proceed')->name('receptionist.validation.proceed');
    });

    Route::controller(DocumentController::class)->group(function () {
        Route::post('/receptionist/documents', 'store')->name('receptionist.documents.store');
        Route::patch('/receptionist/documents/{document}/verify', 'verify')->name('receptionist.documents.verify');

    });
});

Route::middleware('auth', 'prevent-back', 'can:access-social-worker')->group(function (){
    Route::controller(SocialWorkerController::class)->group(function () {
        Route::get('/social-worker/dashboard', 'index')->name('social-worker.dashboard');
        Route::get('/social-worker/assessment', 'pendingAssessment')->name('social-worker.assessment');
        Route::post('/social-worker/assessment/{clientProcessing}', 'storeAssessment')->name('social-worker.assessment.store');

    });
    
});

Route::middleware('auth', 'prevent-back', 'can:access-approving-officer')->controller(ApprovingOfficerController::class)->group(function (){
    Route::get('/approving-officer/dashboard', 'index')->name('approving-officer.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
