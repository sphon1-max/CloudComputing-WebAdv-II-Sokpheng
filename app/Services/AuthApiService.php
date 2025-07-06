<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthApiService
{
  private $baseUrl;

  public function __construct()
  {
    $this->baseUrl = env('API_BASE_URL');
  }

  public function login($email, $password)
  {
    try {
      $response = Http::post($this->baseUrl . '/admin/login', [
        'email' => $email,
        'password' => $password,
        'device_name' => 'admin-dashboard'
      ]);

      if ($response->successful()) {
        $data = $response->json();
        Session::put('api_token', $data['token']);
        Session::put('admin_data', $data['admin']);
        return true;
      }

      return false;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function logout()
  {
    $token = Session::get('api_token');

    if ($token) {
      Http::withToken($token)->post($this->baseUrl . '/admin/logout');
    }

    Session::forget(['api_token', 'admin_data']);
  }

  public function getToken()
  {
    return Session::get('api_token');
  }

  public function isAuthenticated()
  {
    return Session::has('api_token');
  }
}
