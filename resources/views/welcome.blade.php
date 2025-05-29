<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFlow - Enrollment Management System</title>
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
            overflow-x: hidden;
        }

        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            padding: 1.5rem 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 10;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo::before {
            content: "🎓";
            font-size: 2rem;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: white;
            color: #667eea;
        }

        .btn-primary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            position: relative;
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            color: white;
            position: relative;
            z-index: 5;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 3rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-large {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        /* Features Grid */
        .features {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 4rem 2rem;
            margin-top: 2rem;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features h2 {
            text-align: center;
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            color: white;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .feature-card p {
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Role Cards */
        .roles {
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.03);
        }

        .roles-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .roles h2 {
            text-align: center;
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .role-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4f46e5, #06b6d4, #10b981);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .role-card:hover::before {
            opacity: 1;
        }

        .role-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .role-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .role-card p {
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .role-card .btn {
            margin-top: 1rem;
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            padding: 2rem;
            text-align: center;
            color: white;
            opacity: 0.8;
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
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 70%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            right: 20%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.7;
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .auth-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .nav {
                flex-direction: column;
                gap: 1rem;
            }

            .features-grid,
            .roles-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="container">
        <header class="header">
            <nav class="nav">
                <a href="#" class="logo">EduFlow</a>
                <div class="auth-buttons">
                    <a href="/login" class="btn btn-outline">Sign In</a>
                    <a href="/register" class="btn btn-primary">Get Started</a>
                </div>
            </nav>
        </header>

        <main class="hero">
            <div class="hero-content">
                <h1>Welcome to EduFlow</h1>
                <p>Streamline your educational journey with our comprehensive enrollment management system. Connect students, instructors, and administrators in one powerful platform.</p>
                <div class="cta-buttons">
                    <a href="/register" class="btn btn-primary btn-large">Start Your Journey</a>
                    <a href="#features" class="btn btn-outline btn-large">Learn More</a>
                </div>
            </div>
        </main>

        <section id="features" class="features">
            <div class="features-container">
                <h2>Why Choose EduFlow?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <span class="feature-icon">📚</span>
                        <h3>Smart Enrollment</h3>
                        <p>Effortlessly manage course registrations, track capacity, and handle waitlists with our intelligent enrollment system.</p>
                    </div>
                    <div class="feature-card">
                        <span class="feature-icon">👥</span>
                        <h3>Role-Based Access</h3>
                        <p>Secure, customized dashboards for students, instructors, and administrators with appropriate permissions and tools.</p>
                    </div>
                    <div class="feature-card">
                        <span class="feature-icon">📊</span>
                        <h3>Real-Time Analytics</h3>
                        <p>Get instant insights into enrollment trends, course popularity, and student progress with comprehensive reporting.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="roles">
            <div class="roles-container">
                <h2>Choose Your Role</h2>
                <div class="roles-grid">
                    <div class="role-card">
                        <h3>🎓 Student</h3>
                        <p>Browse courses, manage enrollments, track your academic progress, and connect with instructors seamlessly.</p>
                        <a href="/register" class="btn btn-outline">Join as Student</a>
                    </div>
                    <div class="role-card">
                        <h3>👨‍🏫 Instructor</h3>
                        <p>Create and manage courses, track student progress, communicate with learners, and streamline your teaching workflow.</p>
                        <a href="/register" class="btn btn-outline">Join as Instructor</a>
                    </div>
                    <div class="role-card">
                        <h3>⚙️ Administrator</h3>
                        <p>Oversee the entire system, manage users and courses, generate reports, and ensure smooth operations across the platform.</p>
                        <a href="/register" class="btn btn-outline">Join as Admin</a>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <p>&copy; 2025 EduFlow Enrollment Management System. Empowering education through technology.</p>
        </footer>
    </div>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add subtle parallax effect to floating shapes
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const shapes = document.querySelectorAll('.shape');

            shapes.forEach((shape, index) => {
                const speed = 0.1 + (index * 0.05);
                const yPos = -(scrolled * speed);
                shape.style.transform = `translateY(${yPos}px)`;
            });
        });

        // Add entrance animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe cards for animation
        document.querySelectorAll('.feature-card, .role-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>

</html>