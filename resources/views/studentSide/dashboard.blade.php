<x-studentapp-layout>

    <x-slot name="title">
        Dashboard
    </x-slot>

    @slot('content')
    <div class="dashboard">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Student Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back, {{ Auth::user()->name }}!</p>
        </div>

        @if($currentTerm && $currentEnrollments->isNotEmpty())
        <div class="enrollment-alert success">
            <i class="fas fa-check-circle alert-icon"></i>
            <div class="alert-content">
                <h3 class="alert-title">Currently Enrolled in {{ $currentTerm->schoolyear_semester }}</h3>
                <p class="alert-message">You are enrolled in {{ $currentEnrollments->count() }} courses this term.</p>
            </div>
        </div>
        @else
        <div class="enrollment-alert">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            <div class="alert-content">
                <h3 class="alert-title">No Current Enrollment</h3>
                <p class="alert-message">You are not currently enrolled in any courses for the active term.</p>
            </div>
            <div class="alert-action">
                <a href="{{ route('studentSide.enrollment.create') }}" class="btn-primary">Enroll Now</a>
            </div>
        </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $totalEnrollments }}</div>
                        <div class="stat-label">Total Courses Taken</div>
                    </div>
                    <div class="stat-icon purple">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $completedTerms }}</div>
                        <div class="stat-label">Completed Terms</div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $currentYearLevel }}</div>
                        <div class="stat-label">Current Year Level</div>
                    </div>
                    <div class="stat-icon green">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $currentProgram ? $currentProgram->program_code : 'N/A' }}</div>
                        <div class="stat-label">Current Program</div>
                    </div>
                    <div class="stat-icon orange">
                        <i class="fas fa-university"></i>
                    </div>
                </div>
            </div>
        </div>

        @if($currentTerm && $currentEnrollments->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Current Courses</h2>
                <a href="{{ route('studentSide.enrollment.download.cor') }}" class="card-action">
                    Download COR <i class="fas fa-download ml-2"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="courses-grid">
                    @foreach($currentEnrollments as $enrollment)
                    <div class="course-item">
                        <div class="course-code">{{ $enrollment->course->course_code }}</div>
                        <h3 class="course-title">{{ $enrollment->course->course_name }}</h3>
                        <div class="course-details">
                            <span>Section: {{ $enrollment->section->section_name }}</span>
                            <span class="separator">•</span>
                            <span>{{ $enrollment->course->credits }} units</span>
                        </div>
                        @if($enrollment->schedule)
                        <div class="course-details">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $enrollment->schedule->day }} {{ $enrollment->schedule->starting_time }} - {{ $enrollment->schedule->ending_time }}</span>
                        </div>
                        <div class="course-details">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $enrollment->schedule->room->room_name ?? 'TBA' }}</span>
                        </div>
                        <div class="course-instructor">
                            <i class="fas fa-user"></i>
                            <span>{{ $enrollment->schedule->instructor->name ?? 'TBA' }}</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    @endslot
</x-studentapp-layout>