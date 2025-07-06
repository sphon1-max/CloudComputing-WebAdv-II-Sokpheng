<?php

// Test the events API to see the actual structure
$url = 'http://127.0.0.1:8000/api/v1/events';
$token = '2|qzW2vSKPhArSjxveQmkILfOm3eDT26pKqwbIgMZQ6018d9e0';

$options = [
  'http' => [
    'header' => [
      'Content-Type: application/json',
      'Accept: application/json',
      'Authorization: Bearer ' . $token
    ],
    'method' => 'GET'
  ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

echo "=== TESTING EVENTS API ===\n";
echo "URL: $url\n\n";

if ($response) {
  $json = json_decode($response, true);
  if ($json) {
    echo "Full API Response:\n";
    print_r($json);

    if (isset($json['data'])) {
      echo "\nData array count: " . count($json['data']) . "\n";
      if (count($json['data']) > 0) {
        echo "First event structure:\n";
        print_r($json['data'][0]);
      }
    }
  } else {
    echo "JSON decode error: " . json_last_error_msg() . "\n";
    echo "Raw response: " . $response;
  }
} else {
  echo "No response received\n";
  if (isset($http_response_header)) {
    echo "Headers: " . implode("\n", $http_response_header);
  }
}

echo "\n";
