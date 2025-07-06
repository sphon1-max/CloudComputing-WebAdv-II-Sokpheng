<?php

// Test script to check eventdetail page functionality

// Test 1: Get events list to see available event IDs
echo "Testing event list to get available event IDs...\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/admin/events');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Accept: application/json',
  'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2FkbWluL2xvZ2luIiwiaWF0IjoxNzM1MjA3MDgyLCJleHAiOjE3MzUyMTA2ODIsIm5iZiI6MTczNTIwNzA4MiwianRpIjoicEVaUkNMdGdBOWtCTkxBRCIsInN1YiI6IjEiLCJwcnYiOiJlNWI4YzhlNWRhMGZlMzE3NzEzNjZjZGE4MzRhNmU2ZTI0MWM0NGQ0IiwiZ3VhcmQiOiJhZG1pbiJ9.FmfH4Q9JxoEInuWNF1TmNkFt4WLYPzFTR_P2Qk5IZxo'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Events API Response Code: $httpCode\n";

if ($response) {
  $data = json_decode($response, true);
  if (isset($data['data']) && is_array($data['data']) && count($data['data']) > 0) {
    $firstEvent = $data['data'][0];
    $eventId = $firstEvent['id'] ?? null;

    echo "Found event ID: $eventId\n";

    if ($eventId) {
      // Test 2: Get individual event details
      echo "\nTesting individual event details for ID: $eventId...\n";

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/api/admin/events/$eventId");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2FkbWluL2xvZ2luIiwiaWF0IjoxNzM1MjA3MDgyLCJleHAiOjE3MzUyMTA2ODIsIm5iZiI6MTczNTIwNzA4MiwianRpIjoicEVaUkNMdGdBOWtCTkxBRCIsInN1YiI6IjEiLCJwcnYiOiJlNWI4YzhlNWRhMGZlMzE3NzEzNjZjZGE4MzRhNmU2ZTI0MWM0NGQ0IiwiZ3VhcmQiOiJhZG1pbiJ9.FmfH4Q9JxoEInuWNF1TmNkFt4WLYPzFTR_P2Qk5IZxo'
      ]);

      $detailResponse = curl_exec($ch);
      $detailHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);

      echo "Event Detail API Response Code: $detailHttpCode\n";

      if ($detailResponse) {
        $detailData = json_decode($detailResponse, true);
        echo "Event Detail Response Structure:\n";
        echo json_encode($detailData, JSON_PRETTY_PRINT) . "\n";

        // Test 3: Test admin dashboard page access
        echo "\nTesting admin dashboard page access...\n";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8091/events/$eventId/detail");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');

        $pageResponse = curl_exec($ch);
        $pageHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo "Dashboard Event Detail Page Response Code: $pageHttpCode\n";

        if ($pageHttpCode == 200) {
          echo "SUCCESS: Event detail page is accessible!\n";
        } else {
          echo "ERROR: Event detail page returned code $pageHttpCode\n";
          if (strpos($pageResponse, 'login') !== false) {
            echo "Redirected to login page - authentication required.\n";
          }
        }
      } else {
        echo "Failed to get event details from API\n";
      }
    }
  } else {
    echo "No events found in API response\n";
  }
} else {
  echo "Failed to get events from API\n";
}

echo "\nTest completed.\n";
