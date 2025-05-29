<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - EduFlow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Floating Elements */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 8s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 15%;
            animation-delay: 3s;
        }

        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            top: 30%;
            right: 25%;
            animation-delay: 6s;
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            bottom: 20%;
            left: 20%;
            animation-delay: 2s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.6;
            }

            50% {
                transform: translateY(-30px) rotate(180deg);
                opacity: 1;
            }
        }

        /* Main Container */
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 2rem;
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
            animation: slideUp 0.8s ease-out;
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

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-text {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-text::before {
            content: "🎓";
            font-size: 2.5rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .form-header h1 {
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-input {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: white;
        }

        .checkbox-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
        }

        .forgot-password {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            text-align: right;
            margin-bottom: 2rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: white;
        }

        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: white;
            color: #667eea;
            border: none;
            border-radius: 0.75rem;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .btn-primary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .divider span {
            padding: 0 1rem;
        }

        .register-link {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        .register-link a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s ease;
        }

        .register-link a:hover {
            opacity: 0.8;
        }

        .back-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            opacity: 0.8;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .back-home:hover {
            opacity: 1;
            transform: translateX(-5px);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .success-message {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                padding: 2rem;
                margin: 1rem;
            }

            .form-header h1 {
                font-size: 1.75rem;
            }

            .back-home {
                top: 1rem;
                left: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <a href="/" class="back-home">
        <span>←</span> Back to Home
    </a>

    <div class="login-container">
        <div class="logo">
            <a href="/" class="logo-text">EduFlow</a>
        </div>

        <div class="form-header">
            <h1>Welcome Back</h1>
            <p>Sign in to your account to continue</p>
        </div>

        <!-- Session Status -->
        <div id="session-status" style="display: none;"></div>

        <!-- Validation Errors -->
        <div id="validation-errors" style="display: none;"></div>

        <form method="POST" action="/login" id="loginForm">
            <!-- CSRF Token (Laravel) -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter your email address">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    class="form-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password">
            </div>

            <!-- Remember Me -->
            <div class="form-checkbox">
                <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
                <label for="remember_me" class="checkbox-label">Remember me for 30 days</label>
            </div>

            <!-- Forgot Password Link -->
            <a class="forgot-password" href="/forgot-password">
                Forgot your password?
            </a>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary">
                Sign In
            </button>
        </form>

        <div class="divider">
            <span>Don't have an account?</span>
        </div>

        <div class="register-link">
            <a href="/register">Create your account →</a>
        </div>
    </div>

    <script>
        // Form validation and enhancement
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Clear previous errors
            clearMessages();

            // Basic validation
            if (!email || !password) {
                e.preventDefault();
                showError('Please fill in all required fields.');
                return;
            }

            if (!isValidEmail(email)) {
                e.preventDefault();
                showError('Please enter a valid email address.');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Signing In...';
            submitBtn.disabled = true;

            // Re-enable button after 5 seconds as fallback
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showError(message) {
            const errorDiv = document.getElementById('validation-errors');
            errorDiv.innerHTML = `<div class="error-message">${message}</div>`;
            errorDiv.style.display = 'block';
        }

        function showSuccess(message) {
            const statusDiv = document.getElementById('session-status');
            statusDiv.innerHTML = `<div class="success-message">${message}</div>`;
            statusDiv.style.display = 'block';
        }

        function clearMessages() {
            document.getElementById('validation-errors').style.display = 'none';
            document.getElementById('session-status').style.display = 'none';
        }

        // Auto-focus on email field
        window.addEventListener('load', function() {
            document.getElementById('email').focus();
        });

        // Enhanced floating animation
        function enhanceFloatingShapes() {
            const shapes = document.querySelectorAll('.shape');
            shapes.forEach((shape, index) => {
                const randomDelay = Math.random() * 4;
                const randomDuration = 6 + Math.random() * 4;
                shape.style.animationDelay = `${randomDelay}s`;
                shape.style.animationDuration = `${randomDuration}s`;
            });
        }

        enhanceFloatingShapes();
    </script>
</body>

</html>