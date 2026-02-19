<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PaymentController;

Route::middleware(['auth:admin'])->group(function () {
      //http://127.0.0.1:8091/
      Route::get('/dashboard', [EventController::class, 'Eventdash']);

      //http://127.0.0.1:8091/events/{id} to delete
      Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

      //http://127.0.0.1:8091/current-events
      Route::get('/current-events', [EventController::class, 'currentEvents']);

      //http://127.0.0.1:8091/request-events
      Route::get('/request-events', [EventController::class, 'requestEvents']);

      Route::post('/events/{id}/accept', [EventController::class, 'accept'])->name('events.accept');

      Route::get('/events/{id}/detail', [EventController::class, 'show'])->name('events.show');


      //http://127.0.0.1:8091/category
      Route::get('/category', [EventController::class, 'EventCate']);

      Route::delete('/category/{id}', [EventController::class, 'destroyCate'])->name('cate.destroyCate');

      //http://127.0.0.1:8091/organizer
      Route::get('/organizer', [UsersController::class, 'AllOrganizers']);
      //http://127.0.0.1:8091/organizer{id} to delete
      Route::delete('/organizer/{id}', [UsersController::class, 'destroyOrga'])->name('Organizers.destroyOrga');

      //http://127.0.0.1:8091/user
      Route::get('/user', [UsersController::class, 'AllUsers']);
      //http://127.0.0.1:8091/organizer{id} to delete
      Route::delete('/user/{id}', [UsersController::class, 'destroyUser'])->name('Users.destroyUser');

      Route::get('/city', [EventController::class, 'EventCity']);

      Route::delete('/city/{id}', [EventController::class, 'destroyCity'])->name('city.destroyCity');

      //payment
      Route::get('/payments', [PaymentController::class, 'allPayments'])->name('payments.all');

      Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


//login
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
// Add a fallback 'login' route for Laravel's auth system
Route::get('/login', function () {
      return redirect()->route('admin.login');
})->name('login');
//logout

// redirect to login first
Route::redirect('/', '/admin/login');
