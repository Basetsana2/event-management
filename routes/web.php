<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;


use App\Http\Controllers\AdminController;


Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::get('/admin/role-requests', [AdminController::class, 'roleRequests'])->name('admin.role.requests');
    Route::post('/admin/role-requests/{user}/approve', [AdminController::class, 'approve'])->name('admin.role.approve');
});


Route::get('/', [EventController::class, 'home'])->name('home');

/*Route::get('/calendar', [\App\Http\Controllers\EventController::class, 'calendar'])
    ->name('events.calendar')
    ->middleware(['auth'])*/

Route::get('/calendar', [EventController::class, 'calendar'])->name('events.calendar');
Route::get('/calendar/data', [EventController::class, 'calendarData'])->name('events.calendar.data');

Route::resource('registrations', RegistrationController::class)->only(['update'])->middleware('auth');
Route::patch('/registrations/{registration}', [RegistrationController::class, 'update'])->name('registrations.update');

Route::resource('events', EventController::class)->middleware(['auth']);

Route::patch('/admin/registrations/{registration}/approve', [AdminController::class, 'approveRegistration'])->name('admin.registrations.approve');
Route::patch('/admin/registrations/{registration}/decline', [AdminController::class, 'declineRegistration'])->name('admin.registrations.decline');

Route::get('/admin/role-requests', [AdminController::class, 'roleRequests'])->name('admin.role.requests');
Route::post('/admin/role-requests/{user}/approve', [AdminController::class, 'approve'])->name('admin.role.approve');


// Delete event
Route::delete('/admin/events/{event}', [AdminController::class, 'destroyEvent'])->name('admin.events.destroy');

// Delete user
Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');



Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});


Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])
    ->name('registrations.destroy')
    ->middleware(['auth']);



Route::get('/my-registrations', [RegistrationController::class, 'myRegistrations'])
    ->name('registrations.mine')
    ->middleware(['auth']);


Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.mine')->middleware(['auth']);


Route::post('events/{event}/register', [RegistrationController::class, 'register'])->name('events.register');

/*Route::post('registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
Route::post('registrations/{registration}/decline', [RegistrationController::class, 'decline'])->name('registrations.decline'); */

// Show pending registrations (for organizers)
Route::get('/pending-registrations', [RegistrationController::class, 'pending'])
    ->middleware(['auth'])
    ->name('registrations.pending');

// Approve or Decline
Route::post('/registrations/{registration}/approve', [RegistrationController::class, 'approve'])
    ->middleware(['auth'])->name('registrations.approve');

Route::post('/registrations/{registration}/decline', [RegistrationController::class, 'decline'])
    ->middleware(['auth'])->name('registrations.decline');




Route::middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class);
});


Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
