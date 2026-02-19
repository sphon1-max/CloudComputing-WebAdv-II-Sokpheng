<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminAuth
{
  public function handle(Request $request, Closure $next)
  {
    // Check if admin is logged in
    if (!session('admin_logged_in')) {
      Log::info('Admin access denied - not logged in');
      return redirect()->route('admin.login')
        ->with('error', 'Please login to access the admin dashboard.');
    }

    // Check if session has required data
    if (!session('admin_id') || !session('api_token')) {
      Log::warning('Admin session incomplete - missing required data');
      session()->flush();
      return redirect()->route('admin.login')
        ->with('error', 'Your session is invalid. Please login again.');
    }

    // Optional: Check token expiration if available
    $tokenExpiresAt = session('token_expires_at');
    if ($tokenExpiresAt && now()->isAfter($tokenExpiresAt)) {
      Log::info('Admin token expired', [
        'admin_id' => session('admin_id'),
        'expired_at' => $tokenExpiresAt
      ]);
      session()->flush();
      return redirect()->route('admin.login')
        ->with('error', 'Your session has expired. Please login again.');
    }

    // Optional: Update last activity
    session(['last_activity' => now()->toDateTimeString()]);

    return $next($request);
  }
}
