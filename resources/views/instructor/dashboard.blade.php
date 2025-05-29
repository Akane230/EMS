<x-instructorapp-layout>
    <x-slot name="title">Instructor Dashboard</x-slot>

    <div class="dashboard">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Welcome back, {{ $instructor->first_name }}!</h1>
            <p class="dashboard-subtitle">
                Here's your teaching overview
                @if($currentTerm)
                - {{ $currentTerm->schoolyear_semester }}
                @endif
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <!-- Total Courses -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon purple">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <div class="stat-value" id="total-courses">{{ $schedules->unique('course_code')->count() }}</div>
                <div class="stat-label">Total Courses</div>
            </div>

            <!-- Total Sections -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value" id="total-sections">{{ $sections->count() }}</div>
                <div class="stat-label">Sections Handled</div>
            </div>

            <!-- Total Students -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
                <div class="stat-value" id="total-students">{{ $totalStudents }}</div>
                <div class="stat-label">Total Students</div>
            </div>

            <!-- Total Schedules -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon orange">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <div class="stat-value" id="total-schedules">{{ $schedules->count() }}</div>
                <div class="stat-label">Class Schedules</div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="charts-grid">
            <!-- Current Schedule -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Current Schedule</h3>
                    <div class="chart-actions">
                        <a href="{{ route('instructor.schedule.pdf') }}" class="btn-primary">
                            <i class="fas fa-download"></i> Export PDF
                        </a>
                    </div>
                </div>

                @if($schedules->count() > 0)
                <div class="schedule-container">
                    @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    $schedulesByDay = $schedules->groupBy('day');
                    @endphp

                    @foreach($days as $day)
                    @if(isset($schedulesByDay[$day]))
                    <div class="day-schedule">
                        <h4 class="day-title">{{ $day }}</h4>
                        <div class="timeline">
                            @foreach($schedulesByDay[$day] as $schedule)
                            <div class="timeline-item">
                                <div class="timeline-time">
                                    <div class="time-start">
                                        {{ Carbon\Carbon::parse($schedule->starting_time)->format('g:i A') }}
                                    </div>
                                    <div class="time-end">
                                        {{ Carbon\Carbon::parse($schedule->ending_time)->format('g:i A') }}
                                    </div>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">
                                        {{ $schedule->course->course_code }} - {{ $schedule->course->course_name }}
                                    </div>
                                    <div class="timeline-details">
                                        <span><i class="fas fa-users"></i> {{ $schedule->section->section_name }}</span>
                                        <span><i class="fas fa-graduation-cap"></i> {{ $schedule->section->program->program_name }}</span>
                                        @if($schedule->room)
                                        <span><i class="fas fa-map-marker-alt"></i> {{ $schedule->room->roomname }}</span>
                                        @endif
                                        <span><i class="fas fa-credit-card"></i> {{ $schedule->course->credits }} Units</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <p>No schedules found for the current term.</p>
                    @if($currentTerm)
                    <small class="text-gray-500">Current term: {{ $currentTerm->schoolyear_semester }}</small>
                    @endif
                </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Quick Actions</h3>
                </div>

                <div class="actions-grid">
                    <a href="{{ route('instructor.students.index') }}" class="action-item">
                        <div class="action-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="action-label">View All Students</div>
                    </a>

                    <a href="{{ route('instructor.students.pdf') }}" class="action-item">
                        <div class="action-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="action-label">Export Student List</div>
                    </a>

                    <a href="{{ route('instructor.schedule.pdf') }}" class="action-item">
                        <div class="action-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="action-label">Download Schedule</div>
                    </a>

                    <a href="#" onclick="refreshStats()" class="action-item">
                        <div class="action-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <div class="action-label">Refresh Stats</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sections Overview -->
        @if($sections->count() > 0)
        <div class="card margin-top">
            <div class="card-header">
                <h3 class="card-title">Sections Overview</h3>
                <span class="record-count">{{ $sections->count() }} section(s)</span>
            </div>
            <div class="card-body">
                <div class="courses-grid">
                    @foreach($sections as $section)
                    <div class="course-item">
                        <div class="course-code">{{ $section->section_name }}</div>
                        <div class="course-title">{{ $section->program->program_name }}</div>
                        <div class="course-details">
                            <span>{{ $section->schedules->count() }} Course(s)</span>
                            <span class="separator">•</span>
                            <span>{{ $section->students_count }} Student(s)</span>
                        </div>
                        <div class="course-instructor">
                            <a href="{{ route('instructor.section.students', $section->id) }}"
                                class="btn-outline" style="font-size: 12px; padding: 4px 8px;">
                                View Students
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($currentTerm)
        <!-- Current Term Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current Term Information</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 add-gap">
                    <div>
                        <label class="block text-sm font-medium mb-2">Term</label>
                        <p class="text-sm bg-gray-100 dark:bg-gray-800 p-3 rounded">{{ $currentTerm->schoolyear_semester }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <p class="text-sm bg-gray-100 dark:bg-gray-800 p-3 rounded">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs 
                                {{ $currentTerm->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                {{ ucfirst($currentTerm->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Duration</label>
                        <p class="text-sm bg-gray-100 dark:bg-gray-800 p-3 rounded">
                            {{ Carbon\Carbon::parse($currentTerm->start_date)->format('M d, Y') }} -
                            {{ Carbon\Carbon::parse($currentTerm->end_date)->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        // Function to refresh statistics
        async function refreshStats() {
            try {
                const response = await fetch('{{ route("instructor.stat") }}');
                const stats = await response.json();

                document.getElementById('total-courses').textContent = stats.total_courses;
                document.getElementById('total-sections').textContent = stats.total_sections;
                document.getElementById('total-students').textContent = stats.total_students;
                document.getElementById('total-schedules').textContent = stats.total_schedules;

                // Show success notification (you can customize this)
                console.log('Statistics refreshed successfully');

                // Optional: Show a temporary success message
                showNotification('Statistics updated successfully!', 'success');
            } catch (error) {
                console.error('Error refreshing statistics:', error);
                showNotification('Error refreshing statistics', 'error');
            }
        }

        // Function to load students by term
        async function loadStudentsByTerm(termId) {
            try {
                const response = await fetch(`{{ url('instructor/students-by-term') }}/${termId}`);
                const students = await response.json();

                console.log('Students for term:', students);
                // You can add more functionality here to display filtered students
                showNotification(`Found ${students.length} students for selected term`, 'info');
            } catch (error) {
                console.error('Error loading students by term:', error);
                showNotification('Error loading students by term', 'error');
            }
        }

        // Simple notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 3000);
        }

        // Auto-refresh stats every 5 minutes
        setInterval(refreshStats, 300000);
    </script>
</x-instructorapp-layout>