<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Checking what's running on port 8000...\n\n";

try {
  // Test the root URL
  echo "1. Testing http://127.0.0.1:8000\n";
  $response = Http::timeout(5)->get('http://127.0.0.1:8000');
  echo "   Status: " . $response->status() . "\n";
  echo "   Content-Type: " . $response->header('Content-Type') . "\n";
  echo "   First 200 chars: " . substr(strip_tags($response->body()), 0, 200) . "\n\n";

  // Test common API paths
  $paths = [
    '/api',
    '/api/v1',
    '/api/admin',
    '/api/v1/admin',
    '/api/events',
    '/api/v1/events'
  ];

  foreach ($paths as $path) {
    echo "2. Testing http://127.0.0.1:8000{$path}\n";
    $response = Http::timeout(5)->get("http://127.0.0.1:8000{$path}");
    echo "   Status: " . $response->status() . "\n";
    if ($response->status() !== 404) {
      echo "   ✅ FOUND! This path exists\n";
      echo "   Response: " . substr($response->body(), 0, 100) . "...\n";
    } else {
      echo "   ❌ Not found\n";
    }
    echo "\n";
  }
} catch (Exception $e) {
  echo "❌ Connection Error: " . $e->getMessage() . "\n";
}
