<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" href="{{ asset('assets/image/mylogo.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1)"/><stop offset="100%" style="stop-color:rgba(255,255,255,0)"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/><circle cx="900" cy="800" r="80" fill="url(%23a)"/></svg>');
            animation: float 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
            animation: slideDown 0.8s ease-out;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .logo i {
            font-size: 35px;
            color: white;
        }

        .brand-name {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            font-weight: 400;
        }

        .wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out 0.2s both;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .wrapper h1 {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .wrapper .subtitle {
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 40px;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group label {
            position: absolute;
            top: 50%;
            left: 50px;
            transform: translateY(-50%);
            color: #7f8c8d;
            font-size: 16px;
            pointer-events: none;
            transition: all 0.3s ease;
            background: transparent;
            padding: 0 5px;
        }

        .input-group input {
            width: 100%;
            height: 60px;
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid #e8ecef;
            border-radius: 16px;
            font-size: 16px;
            color: #2c3e50;
            padding: 0 20px 0 50px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-group input:focus+label,
        .input-group input:not(:placeholder-shown)+label {
            top: -10px;
            left: 45px;
            font-size: 12px;
            color: #667eea;
            background: white;
            font-weight: 600;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #7f8c8d;
            transition: color 0.3s ease;
        }

        .input-group input:focus~i {
            color: #667eea;
        }

        .btn {
            width: 100%;
            height: 55px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 16px;
            cursor: pointer;
            font-size: 16px;
            color: white;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        }

        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            margin-bottom: 25px;
            padding: 15px 20px;
            border-radius: 12px;
            text-align: center;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert.error {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            border: none;
        }

        .alert.success {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            color: white;
            border: none;
        }

        .api-status {
            position: fixed;
            top: 30px;
            right: 30px;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
            backdrop-filter: blur(10px);
            animation: fadeIn 0.5s ease-out 1s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .api-status.online {
            background: rgba(46, 204, 113, 0.9);
            color: white;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .api-status.offline {
            background: rgba(231, 76, 60, 0.9);
            color: white;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .api-status::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .loading {
            display: none;
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            animation: fadeIn 0.3s ease-out;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #e8ecef;
            border-radius: 50%;
            border-top-color: #667eea;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 480px) {
            .wrapper {
                padding: 40px 30px;
                margin: 0 10px;
            }

            .brand-name {
                font-size: 28px;
            }

            .api-status {
                top: 20px;
                right: 20px;
                padding: 10px 16px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h2 class="brand-name">KH Events</h2>
            <p class="brand-subtitle">Admin Dashboard</p>
        </div>

        <div class="wrapper">
            <h1>Welcome Back</h1>
            <p class="subtitle">Sign in to your admin account</p>

            @if ($errors->any())
            <div class="alert error">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                {{ $errors->first() }}
            </div>
            @endif

            @if (session('success'))
            <div class="alert success">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" id="loginForm">
                @csrf
                <div class="input-group">
                    <input type="email" name="email" placeholder=" " value="{{ old('email') }}" required>
                    <label>Email Address</label>
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="input-group">
                    <input type="password" name="password" placeholder=" " required>
                    <label>Password</label>
                    <i class="fas fa-lock"></i>
                </div>

                <button type="submit" class="btn" id="loginBtn">
                    <span id="loginText">Sign In</span>
                </button>

                <div class="loading" id="loadingMsg">
                    <div class="loading-spinner"></div>
                    Authenticating...
                </div>
            </form>
        </div>
    </div>

    <script>
        // Check API status on page load
        document.addEventListener('DOMContentLoaded', function() {
            checkApiStatus();

            // Add form submission handling
            document.getElementById('loginForm').addEventListener('submit', function() {
                document.getElementById('loginBtn').disabled = true;
                document.getElementById('loadingMsg').style.display = 'block';
            });
        });

        function checkApiStatus() {
            fetch('/admin/health')
                .then(response => response.json())
                .then(data => {
                    const statusEl = document.getElementById('apiStatus');
                    if (data.api_available) {
                        statusEl.innerHTML = '<span>API Online</span>';
                        statusEl.className = 'api-status online';
                    } else {
                        statusEl.innerHTML = '<span>API Offline</span>';
                        statusEl.className = 'api-status offline';
                    }
                })
                .catch(error => {
                    const statusEl = document.getElementById('apiStatus');
                    statusEl.innerHTML = '<span>Status Unknown</span>';
                    statusEl.className = 'api-status offline';
                });
        }
    </script>
</body>

</html>