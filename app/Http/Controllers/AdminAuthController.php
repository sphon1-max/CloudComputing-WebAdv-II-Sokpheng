<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Services\AdminApiService;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // Clear any existing admin session
            $this->clearAdminSession();

            // Build API URL with proper error handling
            $apiBaseUrl = env('API_BASE_URL');
            if (!$apiBaseUrl) {
                Log::error('API_BASE_URL not configured in environment');
                return back()->withErrors(['Authentication service not configured. Please contact administrator.']);
            }

            $apiUrl = rtrim($apiBaseUrl, '/') . '/v1/auth/admin-login';
            Log::info('Attempting admin login to: ' . $apiUrl);

            // Try admin-specific login endpoint first
            $response = Http::timeout(30)
                ->retry(2, 1000)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->post($apiUrl, [
                    'email' => $request->email,
                    'password' => $request->password
                ]);

            Log::info('API Response Status: ' . $response->status());

            if ($response->successful()) {
                $data = $response->json();

                Log::info('API Response received', ['response' => $data]);

                // Check for the correct response structure according to API docs
                // Expected: access_token, user, message, token_type
                if (!isset($data['user']) || !isset($data['access_token'])) {
                    Log::error('Invalid API response structure', ['response' => $data]);
                    return back()->withErrors(['Invalid response from authentication server.']);
                }

                $user = $data['user'];
                $token = $data['access_token']; // Use access_token instead of token

                Log::info('Login successful for user', [
                    'user_id' => $user['id'] ?? 'unknown',
                    'email' => $user['email'] ?? 'unknown',
                    'role' => $user['role'] ?? 'unknown'
                ]);

                // Enhanced role checking - support multiple admin identification methods
                $isAdmin = $this->checkAdminRole($user);

                if ($isAdmin) {
                    // Store comprehensive session data
                    $sessionData = [
                        'admin_logged_in' => true,
                        'admin_id' => $user['id'],
                        'admin_email' => $user['email'],
                        'admin_first_name' => $user['name'] ?? $user['first_name'] ?? 'Admin',
                        'admin_role' => $user['role'] ?? 'admin',
                        'api_token' => $token,
                        'login_time' => now()->toDateTimeString(),
                        'token_expires_at' => $data['expires_at'] ?? null
                    ];

                    session($sessionData);

                    Log::info('Admin session created successfully', [
                        'admin_id' => $user['id'],
                        'admin_email' => $user['email']
                    ]);

                    return redirect('/dashboard')->with('success', 'Welcome back, ' . ($user['name'] ?? 'Admin') . '!');
                } else {
                    Log::warning('Access denied - insufficient privileges', [
                        'user_id' => $user['id'] ?? 'unknown',
                        'email' => $user['email'] ?? 'unknown',
                        'role' => $user['role'] ?? 'unknown',
                        'role_id' => $user['role_id'] ?? 'unknown'
                    ]);
                    return back()->withErrors(['Access denied. You do not have administrator privileges.']);
                }
            } else {
                // Handle different HTTP error codes
                $errorMessage = $this->getApiErrorMessage($response);

                Log::warning('API login failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'email' => $request->email
                ]);

                return back()->withErrors([$errorMessage])->withInput($request->only('email'));
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection failed to authentication server', [
                'error' => $e->getMessage(),
                'api_url' => $apiUrl ?? 'unknown'
            ]);
            return back()->withErrors(['Unable to connect to authentication server. Please try again later.']);
        } catch (\Exception $e) {
            Log::error('Unexpected login error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['An unexpected error occurred. Please try again.']);
        }
    }

    /**
     * Check if user has admin role using multiple identification methods
     */
    private function checkAdminRole($user): bool
    {
        $allowedRoles = config('admin.auth.allowed_roles', ['admin', 'administrator', 'super_admin']);
        $allowedRoleIds = config('admin.auth.allowed_role_ids', [1]);

        // Method 1: Check role field
        if (isset($user['role']) && in_array(strtolower($user['role']), array_map('strtolower', $allowedRoles))) {
            return true;
        }

        // Method 2: Check role_id
        if (isset($user['role_id']) && in_array($user['role_id'], $allowedRoleIds)) {
            return true;
        }

        // Method 3: Check is_admin flag
        if (isset($user['is_admin']) && $user['is_admin']) {
            return true;
        }

        // Method 4: Check permissions array
        if (
            isset($user['permissions']) && is_array($user['permissions']) &&
            (in_array('admin', $user['permissions']) || in_array('admin_access', $user['permissions']))
        ) {
            return true;
        }

        // Method 5: Check user type
        if (isset($user['user_type']) && in_array(strtolower($user['user_type']), array_map('strtolower', $allowedRoles))) {
            return true;
        }

        return false;
    }

    /**
     * Get appropriate error message based on API response
     */
    private function getApiErrorMessage($response): string
    {
        $status = $response->status();
        $body = $response->json();

        // Try to get specific error message from API
        if (isset($body['message'])) {
            return $body['message'];
        }

        // Default messages based on status code
        switch ($status) {
            case 401:
                return 'Invalid email or password. Please check your credentials.';
            case 404:
                return 'Authentication service not found. Please contact administrator.';
            case 422:
                return 'Invalid login data provided.';
            case 429:
                return 'Too many login attempts. Please try again later.';
            case 500:
                return 'Authentication server error. Please try again later.';
            case 503:
                return 'Authentication service temporarily unavailable.';
            default:
                return 'Login failed. Please try again. (Error: ' . $status . ')';
        }
    }

    /**
     * Clear admin session data
     */
    private function clearAdminSession(): void
    {
        session()->forget([
            'admin_logged_in',
            'admin_id',
            'admin_email',
            'admin_first_name',
            'admin_role',
            'api_token',
            'login_time',
            'token_expires_at'
        ]);
    }

    public function logout()
    {
        $token = Session::get('api_token');

        // Logout from main API if token exists
        if ($token) {
            try {
                $apiUrl = rtrim(env('API_BASE_URL'), '/') . '/v1/auth/logout';
                Http::withToken($token)
                    ->timeout(10)
                    ->post($apiUrl);
                Log::info('Successfully logged out from main API');
            } catch (\Exception $e) {
                Log::warning('Failed to logout from main API: ' . $e->getMessage());
                // Continue with local logout even if API logout fails
            }
        }

        // Clear all admin session data
        $this->clearAdminSession();

        Log::info('Admin logged out successfully', [
            'admin_id' => session('admin_id'),
            'logout_time' => now()->toDateTimeString()
        ]);

        return redirect('/admin/login')->with('success', 'You have been logged out successfully.');
    }

    public function healthCheck()
    {
        $apiService = new AdminApiService();
        $baseUrl = env('API_BASE_URL', 'http://localhost:8000/api');

        // Test multiple endpoints to get detailed status
        $results = [];

        // Test 1: Basic connectivity
        try {
            $response = Http::timeout(5)->get($baseUrl);
            $results['base_connectivity'] = [
                'status' => $response->successful() ? 'success' : 'failed',
                'code' => $response->status(),
                'url' => $baseUrl
            ];
        } catch (\Exception $e) {
            $results['base_connectivity'] = [
                'status' => 'error',
                'error' => $e->getMessage(),
                'url' => $baseUrl
            ];
        }

        // Test 2: Events endpoint (we know this works)
        try {
            $eventsUrl = rtrim($baseUrl, '/') . '/v1/events';
            $response = Http::timeout(5)->get($eventsUrl);
            $results['events_endpoint'] = [
                'status' => $response->successful() ? 'success' : 'failed',
                'code' => $response->status(),
                'url' => $eventsUrl
            ];
        } catch (\Exception $e) {
            $results['events_endpoint'] = [
                'status' => 'error',
                'error' => $e->getMessage(),
                'url' => rtrim($baseUrl, '/') . '/v1/events'
            ];
        }

        // Test 3: Admin auth endpoint
        try {
            $authUrl = rtrim($baseUrl, '/') . '/v1/auth/admin-login';
            $response = Http::timeout(5)->get($authUrl);
            $results['auth_endpoint'] = [
                'status' => in_array($response->status(), [200, 405, 422]) ? 'available' : 'failed',
                'code' => $response->status(),
                'url' => $authUrl,
                'note' => $response->status() === 405 ? 'GET not allowed (expected for POST endpoint)' : null
            ];
        } catch (\Exception $e) {
            $results['auth_endpoint'] = [
                'status' => 'error',
                'error' => $e->getMessage(),
                'url' => rtrim($baseUrl, '/') . '/v1/auth/admin-login'
            ];
        }

        // Overall status - check if events endpoint is working
        $isAvailable = isset($results['events_endpoint']) && $results['events_endpoint']['status'] === 'success';

        return response()->json([
            'status' => $isAvailable ? 'healthy' : 'unhealthy',
            'api_available' => $isAvailable,
            'api_base_url' => $baseUrl,
            'timestamp' => now()->toISOString(),
            'detailed_results' => $results,
            'recommendations' => $this->getHealthRecommendations($results)
        ]);
    }

    private function getHealthRecommendations($results): array
    {
        $recommendations = [];

        if ($results['base_connectivity']['status'] === 'error') {
            if (str_contains($results['base_connectivity']['error'] ?? '', 'Connection refused')) {
                $recommendations[] = 'Main API server is not running. Start your Laravel API server on port 8000.';
                $recommendations[] = 'Try running: php artisan serve --port=8000 in your main project directory.';
            } elseif (str_contains($results['base_connectivity']['error'] ?? '', 'timeout')) {
                $recommendations[] = 'Connection timeout. Check if the server is responding slowly or firewall is blocking.';
            } else {
                $recommendations[] = 'Cannot connect to API server. Check the API_BASE_URL in your .env file.';
            }
        }

        if ($results['base_connectivity']['status'] === 'failed') {
            $code = $results['base_connectivity']['code'] ?? 0;
            if ($code === 404) {
                $recommendations[] = 'API base URL returns 404. Check if the URL path is correct.';
            } elseif ($code >= 500) {
                $recommendations[] = 'API server is running but returning server errors. Check the main project logs.';
            }
        }

        return $recommendations;
    }
}
