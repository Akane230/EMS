<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - EduFlow</title>
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
            overflow-x: hidden;
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
            top: 15%;
            left: 15%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            right: 10%;
            animation-delay: 3s;
        }

        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            top: 25%;
            right: 30%;
            animation-delay: 6s;
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            bottom: 15%;
            left: 25%;
            animation-delay: 2s;
        }

        .shape:nth-child(5) {
            width: 60px;
            height: 60px;
            top: 5%;
            right: 5%;
            animation-delay: 4s;
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
        .register-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 2rem;
            padding: 3rem;
            width: 100%;
            max-width: 500px;
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

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
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

        .login-link {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        .login-link a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s ease;
        }

        .login-link a:hover {
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

        .password-requirements {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            margin-top: 0.5rem;
            line-height: 1.4;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .requirement.valid {
            color: #86efac;
        }

        .requirement-icon {
            width: 1rem;
            height: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .checkbox-wrapper:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 1.2rem;
            height: 1.2rem;
            accent-color: white;
        }

        .checkbox-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .checkbox-text a {
            color: white;
            text-decoration: underline;
        }

        /* Loading state */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .register-container {
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
        <div class="shape"></div>
    </div>

    <a href="/" class="back-home">
        <span>←</span> Back to Home
    </a>

    <div class="register-container">
        <div class="logo">
            <a href="/" class="logo-text">EduFlow</a>
        </div>

        <div class="form-header">
            <h1>Create Account</h1>
            <p>Join our learning community today</p>
        </div>

        <!-- Messages -->
        <div id="validation-errors" style="display: none;"></div>
        <div id="success-message" style="display: none;"></div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input
                    id="name"
                    class="form-input"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter your full name">
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="Enter your email address">
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
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
                    autocomplete="new-password"
                    placeholder="Create a strong password">
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="password-requirements">
                    <div class="requirement" id="length-req">
                        <span class="requirement-icon">○</span>
                        At least 8 characters long
                    </div>
                    <div class="requirement" id="uppercase-req">
                        <span class="requirement-icon">○</span>
                        Contains uppercase letter
                    </div>
                    <div class="requirement" id="lowercase-req">
                        <span class="requirement-icon">○</span>
                        Contains lowercase letter
                    </div>
                    <div class="requirement" id="number-req">
                        <span class="requirement-icon">○</span>
                        Contains a number
                    </div>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    id="password_confirmation"
                    class="form-input"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm your password">
                @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Terms and Conditions -->
            <div class="form-group">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="terms" name="terms" required value="1">
                    <div class="checkbox-text">
                        I agree to the <a href="/terms" target="_blank">Terms of Service</a>
                        and <a href="/privacy" target="_blank">Privacy Policy</a>
                    </div>
                </div>
                @error('terms')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn-primary" id="register-btn">
                Create Account
            </button>

            <!-- Divider -->
            <div class="divider">
                <span>Already have an account?</span>
            </div>

            <!-- Login Link -->
            <div class="login-link">
                <a href="{{ route('login') }}">Sign in to your account</a>
            </div>
        </form>
    </div>

    <script>
        // Password validation
        const passwordInput = document.getElementById('password');
        const requirements = {
            length: document.getElementById('length-req'),
            uppercase: document.getElementById('uppercase-req'),
            lowercase: document.getElementById('lowercase-req'),
            number: document.getElementById('number-req')
        };

        passwordInput.addEventListener('input', function() {
            const password = this.value;

            // Length check
            if (password.length >= 8) {
                requirements.length.classList.add('valid');
                requirements.length.querySelector('.requirement-icon').textContent = '✓';
            } else {
                requirements.length.classList.remove('valid');
                requirements.length.querySelector('.requirement-icon').textContent = '○';
            }

            // Uppercase check
            if (/[A-Z]/.test(password)) {
                requirements.uppercase.classList.add('valid');
                requirements.uppercase.querySelector('.requirement-icon').textContent = '✓';
            } else {
                requirements.uppercase.classList.remove('valid');
                requirements.uppercase.querySelector('.requirement-icon').textContent = '○';
            }

            // Lowercase check
            if (/[a-z]/.test(password)) {
                requirements.lowercase.classList.add('valid');
                requirements.lowercase.querySelector('.requirement-icon').textContent = '✓';
            } else {
                requirements.lowercase.classList.remove('valid');
                requirements.lowercase.querySelector('.requirement-icon').textContent = '○';
            }

            // Number check
            if (/\d/.test(password)) {
                requirements.number.classList.add('valid');
                requirements.number.querySelector('.requirement-icon').textContent = '✓';
            } else {
                requirements.number.classList.remove('valid');
                requirements.number.querySelector('.requirement-icon').textContent = '○';
            }
        });

        // Real-time password confirmation check
        const confirmPasswordInput = document.getElementById('password_confirmation');
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;

            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = 'rgba(239, 68, 68, 0.5)';
            } else {
                this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            }
        });
    </script>
</body>

</html>