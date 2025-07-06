<?php

return [
  /*
    |--------------------------------------------------------------------------
    | Admin Dashboard Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the admin dashboard
    |
    */

  // Main API configuration
  'api' => [
    'base_url' => env('API_BASE_URL', 'http://localhost:8000/api'),
    'timeout' => env('API_TIMEOUT', 30),
    'retry_attempts' => env('API_RETRY_ATTEMPTS', 2),
    'retry_delay' => env('API_RETRY_DELAY', 1000), // milliseconds
  ],

  // Authentication settings
  'auth' => [
    'session_lifetime' => env('ADMIN_SESSION_LIFETIME', 480), // minutes
    'auto_logout_on_api_error' => env('AUTO_LOGOUT_ON_API_ERROR', true),
    'allowed_roles' => [
      'admin',
      'administrator',
      'super_admin',
      'organizer' // if organizers should have admin access
    ],
    'allowed_role_ids' => [1], // role IDs that should have admin access
  ],

  // Dashboard settings
  'dashboard' => [
    'items_per_page' => 15,
    'max_recent_items' => 10,
    'refresh_interval' => 300, // seconds
  ],

  // Features that can be enabled/disabled
  'features' => [
    'api_health_check' => true,
    'auto_refresh_dashboard' => false,
    'event_approval_required' => true,
    'user_management' => true,
    'analytics' => true,
  ],

  // Logging
  'logging' => [
    'log_api_requests' => env('LOG_ADMIN_API_REQUESTS', true),
    'log_user_actions' => env('LOG_ADMIN_USER_ACTIONS', true),
  ],

  // UI customization
  'ui' => [
    'app_name' => env('ADMIN_APP_NAME', 'KH Events Admin'),
    'logo_url' => env('ADMIN_LOGO_URL', '/assets/brand/logo.png'),
    'theme' => env('ADMIN_THEME', 'default'),
  ],
];
