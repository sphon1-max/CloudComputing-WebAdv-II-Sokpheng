<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
  private $baseUrl;
  private $token;
  public function __construct()
  {
    $this->baseUrl = env('API_BASE_URL') . '/v1'; // Add v1 prefix
    // Use session token if available, otherwise fallback to env token
    $this->token = session('api_token') ?: env('API_TOKEN');
  }

  private function makeRequest($method, $endpoint, $data = null)
  {
    try {
      $response = Http::withToken($this->token)
        ->timeout(30)
        ->$method($this->baseUrl . $endpoint, $data);

      if ($response->successful()) {
        return $response->json();
      }

      Log::error('API Request Failed', [
        'endpoint' => $endpoint,
        'status' => $response->status(),
        'body' => $response->body()
      ]);

      return null;
    } catch (\Exception $e) {
      Log::error('API Request Exception', [
        'endpoint' => $endpoint,
        'error' => $e->getMessage()
      ]);
      return null;
    }
  }

  // Events (using admin endpoints from API documentation)
  public function getEvents()
  {
    return $this->makeRequest('get', '/admin/events');
  }

  public function getEvent($id)
  {
    return $this->makeRequest('get', "/admin/events/{$id}");
  }

  public function updateEvent($id, $data)
  {
    return $this->makeRequest('put', "/admin/events/{$id}", $data);
  }

  public function deleteEvent($id)
  {
    return $this->makeRequest('delete', "/admin/events/{$id}");
  }

  // Event approval methods
  public function approveEvent($id)
  {
    return $this->makeRequest('post', "/admin/events/{$id}/approve");
  }

  public function rejectEvent($id, $reason = null)
  {
    $data = $reason ? ['reason' => $reason] : [];
    return $this->makeRequest('post', "/admin/events/{$id}/reject", $data);
  }

  public function featureEvent($id, $isFeatured = true)
  {
    return $this->makeRequest('post', "/admin/events/{$id}/feature", ['is_featured' => $isFeatured]);
  }

  // Organizer Dashboard
  public function getOrganizerDashboard()
  {
    return $this->makeRequest('get', '/organizer/analytics/dashboard');
  }

  public function getEventStats($id)
  {
    return $this->makeRequest('get', "/organizer/analytics/event/{$id}/stats");
  }

  // Auth
  public function getProfile()
  {
    return $this->makeRequest('get', '/auth/profile');
  }  // Users Management (admin endpoints)
  public function getUsers()
  {
    return $this->makeRequest('get', '/admin/users');
  }

  public function getUser($id)
  {
    return $this->makeRequest('get', "/admin/users/{$id}");
  }

  public function updateUser($id, $data)
  {
    return $this->makeRequest('put', "/admin/users/{$id}", $data);
  }

  public function deleteUser($id)
  {
    return $this->makeRequest('delete', "/admin/users/{$id}");
  }

  public function toggleUserStatus($id, $isActive)
  {
    return $this->makeRequest('put', "/admin/users/{$id}/status", ['is_active' => $isActive]);
  }

  // Categories Management
  public function getCategories()
  {
    return $this->makeRequest('get', '/admin/categories');
  }

  public function createCategory($data)
  {
    return $this->makeRequest('post', '/admin/categories', $data);
  }

  public function updateCategory($id, $data)
  {
    return $this->makeRequest('put', "/admin/categories/{$id}", $data);
  }

  public function deleteCategory($id)
  {
    return $this->makeRequest('delete', "/admin/categories/{$id}");
  }

  // Bookings Management
  public function getBookings()
  {
    return $this->makeRequest('get', '/admin/bookings');
  }

  public function getBooking($id)
  {
    return $this->makeRequest('get', "/admin/bookings/{$id}");
  }

  public function updateBookingStatus($id, $status)
  {
    return $this->makeRequest('put', "/admin/bookings/{$id}/status", ['status' => $status]);
  }

  // Analytics
  public function getDashboardAnalytics()
  {
    return $this->makeRequest('get', '/admin/analytics/dashboard');
  }

  public function getRevenueAnalytics($period = null, $startDate = null, $endDate = null)
  {
    $params = [];
    if ($period) $params['period'] = $period;
    if ($startDate) $params['start_date'] = $startDate;
    if ($endDate) $params['end_date'] = $endDate;

    $query = !empty($params) ? '?' . http_build_query($params) : '';
    return $this->makeRequest('get', '/admin/analytics/revenue' . $query);
  }

  public function getUserAnalytics()
  {
    return $this->makeRequest('get', '/admin/analytics/users');
  }

  public function getEventAnalytics()
  {
    return $this->makeRequest('get', '/admin/analytics/events');
  }

  // Legacy method for backwards compatibility
  public function getOrganizers()
  {
    // Filter users by role if possible, or use the users endpoint
    return $this->makeRequest('get', '/admin/users?role=organizer');
  }

  public function deleteOrganizer($id)
  {
    return $this->deleteUser($id);
  }
}
