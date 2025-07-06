<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PaymentController;

// Public routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

// Health check route for API status
Route::get('/admin/health', [AdminAuthController::class, 'healthCheck'])->name('admin.health');

// Protected routes (require admin authentication)
Route::middleware('admin.auth')->group(function () {

  //http://127.0.0.1:8091/
  Route::get('/dashboard', [EventController::class, 'Eventdash']);

  //http://127.0.0.1:8091/events/{id} to delete
  Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

  // Event approval routes
  Route::post('/events/{id}/approve', [EventController::class, 'approve'])->name('events.approve');
  Route::post('/events/{id}/reject', [EventController::class, 'reject'])->name('events.reject');

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
  Route::get('/payment', [PaymentController::class, 'allPayments'])->name('payments.all');

  //logout
  Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// redirect to login first
Route::redirect('/', '/admin/login');

// Test route for eventdetail functionality
Route::get('/test-eventdetail', function () {
  $apiService = new \App\Services\ApiService();

  try {
    // Get events first
    $events = $apiService->getEvents();

    if (!$events || !isset($events['data']) || empty($events['data'])) {
      return response()->json(['error' => 'No events found']);
    }

    $firstEvent = $events['data'][0];
    $eventId = $firstEvent['id'];

    // Get single event detail
    $eventDetail = $apiService->getEvent($eventId);

    return response()->json([
      'event_id' => $eventId,
      'event_list_count' => count($events['data']),
      'event_detail_status' => $eventDetail ? 'success' : 'failed',
      'event_detail_keys' => $eventDetail ? array_keys($eventDetail) : [],
      'test_status' => 'success'
    ]);
  } catch (\Exception $e) {
    return response()->json([
      'error' => $e->getMessage(),
      'test_status' => 'failed'
    ]);
  }
});
