<?php

// Test the admin login API directly
$url = 'http://127.0.0.1:8000/api/v1/auth/admin-login';
$data = [
  'email' => 'admin@kh-events.local',
  'password' => 'admin123'
];

$options = [
  'http' => [
    'header' => [
      'Content-Type: application/json',
      'Accept: application/json'
    ],
    'method' => 'POST',
    'content' => json_encode($data)
  ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

// Get response headers
$headers = $http_response_header ?? [];

echo "=== TESTING ADMIN LOGIN API ===\n";
echo "URL: $url\n";
echo "Request Data: " . json_encode($data) . "\n\n";

echo "Response Headers:\n";
foreach ($headers as $header) {
  echo "  $header\n";
}

echo "\nResponse Body:\n";
echo $response ?: "No response body";

// Try to decode JSON
if ($response) {
  $json = json_decode($response, true);
  if ($json) {
    echo "\n\nParsed JSON:\n";
    print_r($json);
  } else {
    echo "\n\nJSON decode error: " . json_last_error_msg();
  }
}

echo "\n";
