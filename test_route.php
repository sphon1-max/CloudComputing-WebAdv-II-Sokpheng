<?php

use Illuminate\Http\Request;
use App\Services\ApiService;

// Simple test to verify eventdetail functionality
Route::get('/test-eventdetail', function (Request $request) {
  $apiService = new ApiService();

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
    'event_detail' => $eventDetail,
    'test_status' => 'success'
  ]);
});
