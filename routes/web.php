<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::post('/event/store', [EventController::class, 'store']);
    Route::get('/get-events', [EventController::class, 'create']);
    Route::get('/payment', [StripeController::class, 'checkout']);
    Route::get('/event', [EventController::class, 'mySessions'])->name('events.mySessions')->middleware('role:user');
    Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('events.destroy')->middleware('role:user');
    Route::put('/event/{id}', [EventController::class, 'update'])->name('events.update')->middleware('role:user');
   Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::put('/admin/event/{id}', [AdminController::class, 'updateEvent'])->name('admin.events.update');
    Route::delete('/admin/event/{id}', [AdminController::class, 'destroyEvent'])->name('admin.events.destroy');


});

require __DIR__.'/auth.php';
