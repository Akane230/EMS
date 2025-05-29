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
            <div class="stat-value">{{ \App\Models\Enrollment::count() }}</div>
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
                    <button class="chart-action active" data-period="monthly">Monthly</button>
                    <button class="chart-action" data-period="quarterly">Quarterly</button>
                    <button class="chart-action" data-period="yearly">Yearly</button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Course Distribution by Program</h3>
            </div>
            <div class="chart-container">
                <canvas id="courseChart"></canvas>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // Get real data from Laravel
            const enrollmentData = @json($enrollmentData);
            const courseDistribution = @json($courseDistribution);

            let enrollmentChart, courseChart;

            // Initialize charts
            document.addEventListener('DOMContentLoaded', function() {
                initializeEnrollmentChart('monthly');
                initializeCourseChart();
                
                // Handle period change buttons
                document.querySelectorAll('.chart-action').forEach(button => {
                    button.addEventListener('click', function() {
                        // Update active button
                        document.querySelectorAll('.chart-action').forEach(btn => {
                            btn.classList.remove('active');
                        });
                        this.classList.add('active');
                        
                        // Update chart
                        const period = this.getAttribute('data-period');
                        updateEnrollmentChart(period);
                    });
                });
            });

            function initializeEnrollmentChart(period) {
                const ctx = document.getElementById('enrollmentChart').getContext('2d');
                const data = getEnrollmentDataByPeriod(period);
                
                enrollmentChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'New Enrollments',
                            data: data.values,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#4f46e5',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Period'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Number of Enrollments'
                                },
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });
            }

            function updateEnrollmentChart(period) {
                const data = getEnrollmentDataByPeriod(period);
                enrollmentChart.data.labels = data.labels;
                enrollmentChart.data.datasets[0].data = data.values;
                enrollmentChart.update();
            }

            function getEnrollmentDataByPeriod(period) {
                if (period === 'yearly') {
                    return enrollmentData.yearly;
                } else if (period === 'quarterly') {
                    return enrollmentData.quarterly;
                } else {
                    return enrollmentData.monthly;
                }
            }

            function initializeCourseChart() {
                const ctx = document.getElementById('courseChart').getContext('2d');
                
                courseChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: courseDistribution.labels,
                        datasets: [{
                            data: courseDistribution.values,
                            backgroundColor: [
                                '#4f46e5', // Purple
                                '#10b981', // Green
                                '#0ea5e9', // Blue
                                '#f59e0b', // Yellow
                                '#ef4444', // Red
                                '#8b5cf6', // Violet
                                '#06b6d4', // Cyan
                                '#84cc16', // Lime
                                '#f97316', // Orange
                                '#ec4899'  // Pink
                            ],
                            borderWidth: 0,
                            hoverBorderWidth: 2,
                            hoverBorderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    padding: 15,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return `${label}: ${value} courses (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '60%',
                        animation: {
                            animateRotate: true,
                            animateScale: false
                        }
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>