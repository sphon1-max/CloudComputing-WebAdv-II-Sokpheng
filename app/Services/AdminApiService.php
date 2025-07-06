<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminApiService
{
  private $baseUrl;
  private $timeout;

  public function __construct()
  {
    $this->baseUrl = rtrim(env('API_BASE_URL'), '/');
    $this->timeout = 30;
  }

  /**
   * Make authenticated API call
   */
  public function makeAuthenticatedRequest($method, $endpoint, $data = [], $token = null)
  {
    try {
      $token = $token ?: session('api_token');

      if (!$token) {
        throw new \Exception('No API token available');
      }

      $url = $this->baseUrl . '/v1' . $endpoint;

      $response = Http::withToken($token)
        ->timeout($this->timeout)
        ->retry(2, 1000)
        ->$method($url, $data);

      Log::info('API Request made', [
        'method' => strtoupper($method),
        'endpoint' => $endpoint,
        'status' => $response->status()
      ]);

      return $response;
    } catch (\Exception $e) {
      Log::error('API request failed', [
        'method' => $method,
        'endpoint' => $endpoint,
        'error' => $e->getMessage()
      ]);
      throw $e;
    }
  }

  /**
   * Test API connection and token validity
   */
  public function testConnection($token = null): array
  {
    try {
      // Use events endpoint since it exists and works
      $response = Http::timeout(10)->get($this->baseUrl . '/v1/events');

      if ($response->successful()) {
        return [
          'status' => 'success',
          'message' => 'API connection successful',
          'data' => $response->json()
        ];
      } else {
        return [
          'status' => 'error',
          'message' => 'API connection failed: ' . $response->status(),
          'data' => null
        ];
      }
    } catch (\Exception $e) {
      return [
        'status' => 'error',
        'message' => 'Connection error: ' . $e->getMessage(),
        'data' => null
      ];
    }
  }

  /**
   * Get admin dashboard statistics
   */
  public function getDashboardStats(): array
  {
    try {
      $response = $this->makeAuthenticatedRequest('get', '/admin/analytics/dashboard');

      if ($response->successful()) {
        return $response->json();
      }

      return [
        'total_users' => 0,
        'total_events' => 0,
        'total_bookings' => 0,
        'total_revenue' => 0,
        'pending_events' => 0
      ];
    } catch (\Exception $e) {
      Log::error('Failed to fetch dashboard stats: ' . $e->getMessage());
      return [
        'total_users' => 0,
        'total_events' => 0,
        'total_bookings' => 0,
        'total_revenue' => 0,
        'pending_events' => 0
      ];
    }
  }

  /**
   * Get paginated users
   */
  public function getUsers($page = 1, $search = '', $role = ''): array
  {
    try {
      $params = array_filter([
        'page' => $page,
        'search' => $search,
        'role' => $role,
        'per_page' => 15
      ]);

      $response = $this->makeAuthenticatedRequest('get', '/admin/users?' . http_build_query($params));

      if ($response->successful()) {
        return $response->json();
      }

      return ['data' => [], 'total' => 0];
    } catch (\Exception $e) {
      Log::error('Failed to fetch users: ' . $e->getMessage());
      return ['data' => [], 'total' => 0];
    }
  }

  /**
   * Get paginated events
   */
  public function getEvents($page = 1, $search = '', $status = ''): array
  {
    try {
      $params = array_filter([
        'page' => $page,
        'search' => $search,
        'status' => $status,
        'per_page' => 15
      ]);

      $response = $this->makeAuthenticatedRequest('get', '/admin/events?' . http_build_query($params));

      if ($response->successful()) {
        return $response->json();
      }

      return ['data' => [], 'total' => 0];
    } catch (\Exception $e) {
      Log::error('Failed to fetch events: ' . $e->getMessage());
      return ['data' => [], 'total' => 0];
    }
  }

  /**
   * Approve an event
   */
  public function approveEvent($eventId): bool
  {
    try {
      $response = $this->makeAuthenticatedRequest('post', "/admin/events/{$eventId}/approve");
      return $response->successful();
    } catch (\Exception $e) {
      Log::error("Failed to approve event {$eventId}: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Reject an event
   */
  public function rejectEvent($eventId, $reason = ''): bool
  {
    try {
      $data = $reason ? ['reason' => $reason] : [];
      $response = $this->makeAuthenticatedRequest('post', "/admin/events/{$eventId}/reject", $data);
      return $response->successful();
    } catch (\Exception $e) {
      Log::error("Failed to reject event {$eventId}: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Delete a resource
   */
  public function deleteResource($type, $id): bool
  {
    try {
      $endpoint = "/admin/{$type}/{$id}";
      $response = $this->makeAuthenticatedRequest('delete', $endpoint);
      return $response->successful();
    } catch (\Exception $e) {
      Log::error("Failed to delete {$type} {$id}: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Check if API is available
   */
  public function isApiAvailable(): bool
  {
    try {
      $response = Http::timeout(5)->get($this->baseUrl . '/health');
      return $response->successful();
    } catch (\Exception $e) {
      return false;
    }
  }
}
