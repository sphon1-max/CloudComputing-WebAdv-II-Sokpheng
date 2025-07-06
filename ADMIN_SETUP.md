# Admin Dashboard Setup Guide

## Overview
This Laravel admin dashboard connects to your main KH Events API to provide administrative functionality.

## Configuration

### Environment Variables
Add these to your `.env` file:

```env
# Main API Configuration
API_BASE_URL=http://localhost:8000/api
API_TIMEOUT=30
API_RETRY_ATTEMPTS=2

# Admin Dashboard Settings
ADMIN_APP_NAME="KH Events Admin"
ADMIN_SESSION_LIFETIME=480
AUTO_LOGOUT_ON_API_ERROR=true
LOG_ADMIN_API_REQUESTS=true
```

### API Authentication Options

#### Option 1: Admin Login (Recommended for Production)
Use the admin login form at `/admin/login` with proper admin credentials.

#### Option 2: Direct API Token (Development Only)
For development, you can use a direct API token:
```
Bearer 2|qzW2vSKPhArSjxveQmkILfOm3eDT26pKqwbIgMZQ6018d9e0
```

## Features

### Enhanced Authentication
- ✅ Multiple role checking methods (role, role_id, is_admin, permissions, user_type)
- ✅ Token expiration handling
- ✅ Session validation
- ✅ Comprehensive error handling
- ✅ API connection testing

### Admin API Service
A centralized service (`AdminApiService`) for all API interactions:
- Dashboard statistics
- User management
- Event management
- Resource operations
- Health checks

### Enhanced Login Page
- Real-time API status indicator
- Better error/success messaging
- Loading states
- Input validation
- Responsive design

### Security Features
- Session timeout handling
- Token validation
- Automatic logout on API errors
- Comprehensive logging
- CSRF protection

## Usage

### Starting the Dashboard
1. Make sure your main API is running on the configured URL
2. Start this Laravel application: `php artisan serve --port=8091`
3. Access admin login: `http://localhost:8091/admin/login`

### Admin Credentials
Depending on your main API setup, use appropriate admin credentials.

### API Endpoints
The dashboard uses these main API endpoints:
- `POST /v1/auth/login` - Admin authentication
- `POST /v1/auth/logout` - Logout
- `GET /v1/admin/*` - Various admin operations

### Health Check
Check API connectivity: `http://localhost:8091/admin/health`

## Troubleshooting

### Common Issues

#### "Unable to connect to authentication server"
- Check if your main API is running
- Verify `API_BASE_URL` in `.env`
- Check network connectivity

#### "Access denied. You do not have administrator privileges"
- Verify user has admin role in the main API
- Check role configuration in `config/admin.php`

#### "Your session has expired"
- Token may have expired
- API might be returning 401 errors
- Check session configuration

### Logs
Check these log files for debugging:
- `storage/logs/laravel.log` - General application logs
- Look for "Admin" tagged entries for dashboard-specific logs

## Development

### Adding New Admin Features
1. Create API endpoints in your main project
2. Add methods to `AdminApiService`
3. Create controllers for your admin pages
4. Add routes in `routes/web.php`

### Customization
- Modify `config/admin.php` for configuration
- Update views in `resources/views/admin/`
- Customize middleware in `app/Http/Middleware/AdminAuth.php`

## Security Notes
- Always use HTTPS in production
- Configure proper CORS settings in your main API
- Use environment-specific configuration
- Regularly rotate API tokens
- Monitor access logs
