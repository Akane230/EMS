<x-app-layout>
    <x-slot name="title">
        EMS Dashboard
    </x-slot>

    <div class="dashboard-header">
        <h1 class="dashboard-title">Welcome to the Enrollment Management System</h1>
        <p class="dashboard-subtitle">Monitor and manage your educational institution data</p>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> 12%
                </div>
            </div>
            <div class="stat-value">{{ \App\Models\Student::count() }}</div>
            <div class="stat-label">Total Students</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> 5%
                </div>
            </div>
            <div class="stat-value">{{ \App\Models\Course::count() }}</div>
            <div class="stat-label">Total Courses</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> 8%
                </div>
            </div>
            <div class="stat-value">{{ \App\Models\Instructor::count() }}</div>
            <div class="stat-label">Total Instructors</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orange">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-trend trend-down">
                    <i class="fas fa-arrow-down"></i> 3%
                </div>
            </div>
            <div class="stat-value">1,248</div>
            <div class="stat-label">Active Enrollments</div>
        </div>
    </div>

    <!-- Module Cards -->
    <div class="modules-grid">
        <div class="module-card">
            <div class="module-icon purple">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h3 class="module-title">Students</h3>
            <p class="module-description">Manage student records including personal information and enrollment details.</p>
            <div class="module-footer">
                <span class="record-count">{{ \App\Models\Student::count() }} Records</span>
                <a href="{{ route('students.index') }}" class="module-action">
                    Manage <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="module-card">
            <div class="module-icon blue">
                <i class="fas fa-book"></i>
            </div>
            <h3 class="module-title">Courses</h3>
            <p class="module-description">Manage course information including course codes, titles, descriptions, and unit counts.</p>
            <div class="module-footer">
                <span class="record-count">{{ \App\Models\Course::count() }} Records</span>
                <a href="{{ route('courses.index') }}" class="module-action">
                    Manage <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="module-card">
            <div class="module-icon green">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h3 class="module-title">Instructors</h3>
            <p class="module-description">Manage instructor information including teachers and administrative personnel.</p>
            <div class="module-footer">
                <span class="record-count">{{ \App\Models\Instructor::count() }} Records</span>
                <a href="{{ route('instructors.index') }}" class="module-action">
                    Manage <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Student Enrollment Trend</h3>
                <div class="chart-actions">
                    <button class="chart-action active">Monthly</button>
                    <button class="chart-action">Quarterly</button>
                    <button class="chart-action">Yearly</button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Course Distribution</h3>
            </div>
            <div class="chart-container">
                <canvas id="courseChart"></canvas>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // Initialize charts
            document.addEventListener('DOMContentLoaded', function() {
                // Enrollment Chart
                const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
                const enrollmentChart = new Chart(enrollmentCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'New Enrollments',
                            data: [12, 19, 15, 22, 18, 24, 17, 21, 30, 26, 20, 28],
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Course Distribution Chart
                const courseCtx = document.getElementById('courseChart').getContext('2d');
                const courseChart = new Chart(courseCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Science', 'Arts', 'Business', 'Technology', 'Health'],
                        datasets: [{
                            data: [35, 25, 20, 15, 5],
                            backgroundColor: [
                                '#4f46e5',
                                '#10b981',
                                '#0ea5e9',
                                '#f59e0b',
                                '#ef4444'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            }
                        },
                        cutout: '70%'
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>