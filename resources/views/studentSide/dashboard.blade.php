<x-studentapp-layout title="Student Dashboard">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Welcome back, {{ $student->first_name }}!</h1>
        <p class="dashboard-subtitle">Here's your academic overview for this term.</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
            <div class="stat-value">{{ $currentEnrollments->count() }}</div>
            <div class="stat-label">Current Courses</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalEnrollments }}</div>
            <div class="stat-label">Total Enrollments</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="stat-value">{{ $completedTerms }}</div>
            <div class="stat-label">Terms Completed</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orange">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <div class="stat-value">{{ $currentYearLevel }}{{ $currentYearLevel == 1 ? 'st' : ($currentYearLevel == 2 ? 'nd' : ($currentYearLevel == 3 ? 'rd' : 'th')) }}</div>
            <div class="stat-label">Year Level</div>
        </div>
    </div>

    <!-- Enrollment Alert -->
    @if($currentTerm && $currentEnrollments->isEmpty())
        <div class="enrollment-alert">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Enrollment Available</div>
                <div class="alert-message">
                    Enrollment for {{ $currentTerm->schoolyear_semester }} is now open. Secure your spot in your preferred courses.
                </div>
            </div>
            <div class="alert-action">
                <a href="{{ route('studentSide.enrollment.create') }}" class="btn-primary">
                    <i class="fas fa-plus-circle"></i> Enroll Now
                </a>
            </div>
        </div>
    @elseif($currentEnrollments->isNotEmpty())
        <div class="enrollment-alert success">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Successfully Enrolled</div>
                <div class="alert-message">
                    You are enrolled in {{ $currentEnrollments->count() }} courses for {{ $currentTerm->schoolyear_semester }}.
                </div>
            </div>
            <div class="alert-action">
                <a href="{{ route('studentSide.enrollment.download.cor') }}" class="btn-secondary">
                    <i class="fas fa-download"></i> Download COR
                </a>
            </div>
        </div>
    @endif

    <!-- Main Content Grid -->
    <div class="cards-grid">
        <!-- Current Courses -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current Courses</h3>
                @if($currentEnrollments->isNotEmpty())
                    <a href="{{ route('studentSide.enrollment.index') }}" class="card-action">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($currentEnrollments->isNotEmpty())
                    <div class="courses-grid">
                        @foreach($currentEnrollments->take(4) as $enrollment)
                            <div class="course-item {{ $enrollment->course->program->program_name === 'General Education' ? 'ge-course' : '' }}">
                                <div class="course-code">
                                    {{ $enrollment->course->course_code }}
                                    @if($enrollment->course->program->program_name === 'General Education')
                                        <span class="ge-badge">GE</span>
                                    @endif
                                </div>
                                <div class="course-title">{{ $enrollment->course->course_name }}</div>
                                <div class="course-details">
                                    <span>{{ $enrollment->course->credits }} units</span>
                                    <span class="separator">•</span>
                                    <span>{{ $enrollment->section->section_name }}</span>
                                    @if($enrollment->schedule)
                                        <span class="separator">•</span>
                                        <span>{{ $enrollment->schedule->day }}</span>
                                    @endif
                                </div>
                                @if($enrollment->schedule && $enrollment->schedule->instructor)
                                    <div class="course-instructor">
                                        <i class="fas fa-user-tie"></i> 
                                        {{ $enrollment->schedule->instructor->first_name }} {{ $enrollment->schedule->instructor->last_name }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <p>No courses enrolled for this term</p>
                        @if($currentTerm)
                            <a href="{{ route('studentSide.enrollment.create') }}" class="btn-outline">
                                <i class="fas fa-plus"></i> Enroll in Courses
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Today's Schedule</h3>
                <span class="card-action">{{ now()->format('l, M j') }}</span>
            </div>
            <div class="card-body">
                @php
                    $todaySchedules = $currentEnrollments->filter(function($enrollment) {
                        return $enrollment->schedule && $enrollment->schedule->day === now()->format('l');
                    })->sortBy('schedule.starting_time');
                @endphp

                @if($todaySchedules->isNotEmpty())
                    <div class="timeline">
                        @foreach($todaySchedules as $enrollment)
                            <div class="timeline-item">
                                <div class="timeline-time">
                                    <div class="time-start">{{ date('g:i A', strtotime($enrollment->schedule->starting_time)) }}</div>
                                    <div class="time-end">{{ date('g:i A', strtotime($enrollment->schedule->ending_time)) }}</div>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">{{ $enrollment->course->course_code }}</div>
                                    <div class="timeline-details">
                                        @if($enrollment->schedule->room)
                                            <span><i class="fas fa-map-marker-alt"></i>{{ $enrollment->schedule->room->room_name }}</span>
                                        @endif
                                        @if($enrollment->schedule->instructor)
                                            <span><i class="fas fa-user"></i>{{ $enrollment->schedule->instructor->first_name }} {{ $enrollment->schedule->instructor->last_name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <p>No classes scheduled for today</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Program & Academic Info -->
    @if($currentProgram)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Academic Information</h3>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon purple">
                                <i class="fas fa-university"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $currentProgram->program_name }}</div>
                        <div class="stat-label">Current Program</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon blue">
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>
                        <div class="stat-value">Year {{ $currentYearLevel }}</div>
                        <div class="stat-label">Current Level</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon green">
                                <i class="fas fa-calculator"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $currentEnrollments->sum('course.credits') }}</div>
                        <div class="stat-label">Total Units</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon orange">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $currentEnrollments->first()->section->section_name ?? 'N/A' }}</div>
                        <div class="stat-label">Section</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="cards-grid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Documents</h3>
            </div>
            <div class="card-body">
                <div class="document-list">
                    @if($currentEnrollments->isNotEmpty())
                        <a href="{{ route('studentSide.enrollment.download.cor') }}" class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-title">Certificate of Registration</div>
                                <div class="document-description">Download your current term COR</div>
                            </div>
                            <div class="document-action">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>
                    @endif
                    
                    <a href="{{ route('studentSide.enrollment.index') }}" class="document-item">
                        <div class="document-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="document-info">
                            <div class="document-title">Enrollment History</div>
                            <div class="document-description">View all past enrollments</div>
                        </div>
                        <div class="document-action">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="actions-grid">
                    @if($currentTerm && $currentEnrollments->isEmpty())
                        <a href="{{ route('studentSide.enrollment.create') }}" class="action-item">
                            <div class="action-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="action-label">Enroll Now</div>
                        </a>
                    @endif
                    
                    <a href="{{ route('studentSide.enrollment.index') }}" class="action-item">
                        <div class="action-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="action-label">View Enrollments</div>
                    </a>
                    
                    @if($currentEnrollments->isNotEmpty())
                        <a href="{{ route('studentSide.enrollment.download.cor') }}" class="action-item">
                            <div class="action-icon">
                                <i class="fas fa-download"></i>
                            </div>
                            <div class="action-label">Download COR</div>
                        </a>
                    @endif
                    
                    <a href="{{ route('profile.edit') }}" class="action-item">
                        <div class="action-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="action-label">Edit Profile</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-studentapp-layout>