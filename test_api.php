<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing API connection to main project...\n";
echo "API URL: http://127.0.0.1:8000/api/v1\n";
echo "Token: 2|qzW2vSKPhArSjxveQmkILfOm3eDT26pKqwbIgMZQ6018d9e0\n\n";

try {
  // Test basic connectivity
  echo "1. Testing basic API connectivity...\n";
  $response = Http::timeout(10)->get('http://127.0.0.1:8000/api');
  echo "   Status: " . $response->status() . "\n";
  echo "   Response: " . substr($response->body(), 0, 100) . "...\n\n";

  // Test with authentication
  echo "2. Testing authenticated endpoint...\n";
  $response = Http::withToken('2|qzW2vSKPhArSjxveQmkILfOm3eDT26pKqwbIgMZQ6018d9e0')
    ->timeout(10)
    ->get('http://127.0.0.1:8000/api/v1/admin/profile');

  echo "   Status: " . $response->status() . "\n";
  if ($response->successful()) {
    echo "   ✅ SUCCESS! API is accessible\n";
    echo "   Response: " . $response->body() . "\n";
  } else {
    echo "   ❌ FAILED! Status: " . $response->status() . "\n";
    echo "   Error: " . $response->body() . "\n";
  }
} catch (Exception $e) {
  echo "❌ Connection Error: " . $e->getMessage() . "\n";
}
