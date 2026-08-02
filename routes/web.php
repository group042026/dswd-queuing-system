<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovingOfficerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\SocialWorkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'prevent-back', 'can:access-admin')->controller(AdminController::class)->group(function (){
    Route::get('/admin/dashboard', 'index')->name('admin.dashboard');
    Route::get('/admin/users', 'userList')->name('admin.users.list');

    Route::post('/admin/users', 'storeUser')->name('admin.users.store');
    Route::put('/admin/users/{user}', 'update')->name('admin.users.update');
    // Route::get('/admin/users/{user}', 'showUser')->name('admin.users.show');
    Route::delete('/admin/users/{user}', 'destroy')->name('admin.users.destroy');
    Route::get('/admin/queue', 'monitor')->name('admin.queue.monitor');


});

Route::middleware('auth', 'prevent-back', 'can:access-receptionist')->controller(ReceptionistController::class)->group(function (){
    Route::get('/receptionist/dashboard', 'index')->name('receptionist.dashboard');
    Route::get('/receptionist/clients/create', 'create')->name('receptionist.clients.create');
    Route::post('/receptionist/clients', 'store')->name('receptionist.clients.store');
});

Route::middleware('auth', 'prevent-back', 'can:access-social-worker')->controller(SocialWorkerController::class)->group(function (){
    Route::get('/social-worker/dashboard', 'index')->name('social-worker.dashboard');
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
