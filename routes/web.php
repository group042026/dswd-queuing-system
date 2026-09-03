<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovingOfficerController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\ReleasingController;
use App\Http\Controllers\ReportController;
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

Route::get('/public/queue-board', [QueueController::class, 'publicQueue'])->name('public.public-queue');
Route::get('/public/queue-board/data', [QueueController::class, 'liveQueueData'])->name('public.public-queue.data');

Route::middleware('auth', 'prevent-back', 'can:access-admin')->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', 'index')->name('admin.dashboard');
        Route::get('/admin/dashboard-data', 'dashboardData')->name('admin.dashboard.data');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/admin/users', 'userList')->name('admin.users.list');
        Route::post('/admin/users', 'storeUser')->name('admin.users.store');
        Route::put('/admin/users/{user}', 'update')->name('admin.users.update');
        Route::delete('/admin/users/{user}', 'destroy')->name('admin.users.destroy');
    });

    Route::controller(QueueController::class)->group(function () {
        Route::get('/admin/queue', 'monitor')->name('admin.queue.monitor');
        Route::get('/admin/queue-monitor-data', 'monitorData')->name('admin.queue.monitor.data');
        Route::patch('/admin/queue/{queue}/cancel', 'cancelQueue')->name('admin.queue.cancel');

    });

    Route::controller(ActivityLogController::class)->group(function () {
        Route::get('/admin/activitylogs', 'index')->name('admin.activitylogs');
    });

    Route::controller(ReportController::class)->group(function (){
        Route::get('/admin/daily-client', 'dailyClientReport')->name('admin.daily-client');
        Route::get('/admin/daily-client/export', 'exportDailyClientReport')->name('admin.daily-client.export');

        Route::get('/admin/monthly-transaction', 'monthlyTransactionReport')->name('admin.monthly-transaction');
        Route::get('/admin/monthly-transaction/export', 'exportMonthlyTransactionReport')->name('admin.monthly-transaction.export');

        Route::get('/admin/queue-performance', 'queuePerformanceReport')->name('admin.queue-performance');
        Route::get('/admin/queue-performance/export', 'exportQueuePerformanceReport')->name('admin.queue-performance.export');

        Route::get('/admin/client-processing', 'clientProcessingReport')->name('admin.client-processing');
        Route::get('/admin/client-processing/export', 'exportClientProcessingReport')->name('admin.client-processing.export');
    });

});

Route::middleware('auth', 'prevent-back', 'can:access-receptionist')->group(function () {

    Route::controller(ReceptionistController::class)->group(function () {
        Route::get('/receptionist/dashboard', 'index')->name('receptionist.dashboard');
        Route::get('/receptionist/dashboard-data', 'dashboardData')->name('receptionist.dashboard.data');
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

    // Route::controller(ReleasingController::class)->group(function (){
    //     Route::get('/receptionist/releasing', 'index')->name('receptionist.releasing');
    //     Route::get('/receptionist/releasing/data', 'releasingData')->name('receptionist.releasing.data');
    //     Route::post('/receptionist/releasing/{clientProcessing}/release', 'release')->name('receptionist.releasing.release');
    // });
});

Route::middleware('auth', 'prevent-back', 'can:access-social-worker')->group(function (){

    Route::controller(SocialWorkerController::class)->group(function () {
        Route::get('/social-worker/dashboard', 'index')->name('social-worker.dashboard');
        Route::get('/social-worker/dashboard-data', 'dashboardData')->name('social-worker.dashboard.data');
        Route::get('/social-worker/assessment', 'pendingAssessment')->name('social-worker.assessment');
        Route::post('/social-worker/assessment/{clientProcessing}', 'storeAssessment')->name('social-worker.assessment.store');
        Route::get('/social-worker/returned', 'returnedAssessments')->name('social-worker.returned');
        // Route::post('/social-worker/returned/{clientProcessing}/resume', 'resumeAssessment')->name('social-worker.returned.resume');
    });

    Route::controller(DocumentController::class)->group(function (){
        Route::post('/social-worker/documents', 'store')->name('social-worker.documents.store');
        Route::patch('/social-worker/documents/{document}/verify', 'verify')->name('social-worker.documents.verify');
    });
    
});

Route::middleware('auth', 'prevent-back', 'can:access-approving-officer')->group(function (){
    Route::controller(ApprovingOfficerController::class)->group(function (){
        Route::get('/approving-officer/dashboard', 'index')->name('approving-officer.dashboard');
        Route::get('/approving-officer/dashboard-data', 'dashboardData')->name('approving-officer.dashboard.data');
        Route::get('/approving-officer/review', 'pendingReview')->name('approving-officer.review');
        Route::post('/approving-officer/review/{clientProcessing}/decide', 'decide')->name('approving-officer.review.decide');
    });

});

Route::middleware('auth', 'prevent-back', 'can:access-releasing')->group(function () {
    Route::controller(ReleasingController::class)->group(function () {
        Route::get('/approving-officer/releasing', 'index')->name('approving-officer.releasing');
        Route::get('/approving-officer/releasing/data', 'releasingData')->name('approving-officer.releasing.data');
        Route::post('/approving-officer/releasing/{clientProcessing}/release', 'release')->name('approving-officer.releasing.release');
    });
});

Route::middleware('auth', 'prevent-back', 'can:access-cashier')->group(function () {
    Route::get('/cashier/dashboard', [CashierController::class, 'index'])->name('cashier.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
