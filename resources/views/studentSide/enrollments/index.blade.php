<x-studentapp-layout title="My Enrollments">
    <div class="dashboard-header">
        <h1 class="dashboard-title">My Enrollments</h1>
        <p class="dashboard-subtitle">View your enrollment history across all terms.</p>
    </div>

    <!-- Action Bar -->
    <div class="add-export-container">
        <div class="flex items-center space-x-4">
            @php
            $currentTerm = \App\Models\Term::where('status', 'active')->first();
            $hasCurrentEnrollment = false;
            if ($currentTerm) {
            $hasCurrentEnrollment = \App\Models\Enrollment::where('student_id', $student->id)
            ->where('term_id', $currentTerm->id)->exists();
            }
            @endphp

            @if($currentTerm && !$hasCurrentEnrollment)
            <a href="{{ route('studentSide.enrollment.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle"></i> Enroll for {{ $currentTerm->schoolyear_semester }}
            </a>
            @endif

            @if($enrollmentsByTerm->isNotEmpty())
            <a href="{{ route('studentSide.enrollment.download.cor') }}" class="btn-secondary">
                <i class="fas fa-download"></i> Download Current COR
            </a>
            @endif
        </div>
    </div>

    @if($enrollmentsByTerm->isNotEmpty())
    <!-- Enrollments by Term -->
    @foreach($enrollmentsByTerm as $termData)
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">{{ $termData['term']->schoolyear_semester }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $termData['enrollments']->count() }} courses • {{ $termData['total_units'] }} total units
                    @if($termData['term']->status === 'active')
                    <span class="ml-2 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded text-xs font-medium">
                        Current Term
                    </span>
                    @endif
                </p>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Year {{ $termData['enrollments']->first()->year_level }}
            </div>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Course
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Credits
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Section
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Schedule
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Instructor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Room
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($termData['enrollments'] as $enrollment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 {{ $enrollment->course->program->program_name === 'General Education' ? 'ge-course' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $enrollment->course->course_code }}
                                        @if($enrollment->course->program->program_name === 'General Education')
                                        <span class="ge-badge">GE</span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $enrollment->course->course_name }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $enrollment->course->program->program_name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $enrollment->course->credits }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $enrollment->section->section_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($enrollment->schedule)
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $enrollment->schedule->day }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ date('g:i A', strtotime($enrollment->schedule->starting_time)) }} -
                                    {{ date('g:i A', strtotime($enrollment->schedule->ending_time)) }}
                                </div>
                                @else
                                <span class="text-sm text-gray-400 dark:text-gray-500">TBA</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($enrollment->schedule && $enrollment->schedule->instructor)
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $enrollment->schedule->instructor->first_name }} {{ $enrollment->schedule->instructor->last_name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $enrollment->schedule->instructor->email ?? '' }}
                                </div>
                                @else
                                <span class="text-sm text-gray-400 dark:text-gray-500">TBA</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($enrollment->schedule && $enrollment->schedule->room)
                                {{ $enrollment->schedule->room->roomname }}
                                @else
                                <span class="text-gray-400 dark:text-gray-500">TBA</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">
                                Total Units: {{ $termData['total_units'] }}
                            </td>
                            <td class="px-6 py-3 text-right">
                                @if($termData['term']->status === 'active')
                                <a href="{{ route('studentSide.enrollment.download.cor') }}" class="text-primary hover:text-primary-dark">
                                    <i class="fas fa-download"></i> Download COR
                                </a>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <!-- Empty State -->
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="text-lg font-medium mb-2">No Enrollments Found</h3>
                <p class="mb-6">You haven't enrolled in any courses yet. Start your academic journey by enrolling in courses.</p>
                @if($currentTerm)
                <a href="{{ route('studentSide.enrollment.create') }}" class="btn-primary">
                    <i class="fas fa-plus-circle"></i> Enroll for {{ $currentTerm->schoolyear_semester }}
                </a>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No active enrollment term available. Please contact the registrar.
                </p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Student Information Summary -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Academic Summary</h3>
        </div>
        <div class="card-body">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon blue">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $enrollmentsByTerm->sum(function($term) { return $term['enrollments']->count(); }) }}</div>
                    <div class="stat-label">Total Courses Taken</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon green">
                            <i class="fas fa-calculator"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $enrollmentsByTerm->sum('total_units') }}</div>
                    <div class="stat-label">Total Units Earned</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon purple">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $enrollmentsByTerm->count() }}</div>
                    <div class="stat-label">Terms Enrolled</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon orange">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                    <div class="stat-value">
                        @if($enrollmentsByTerm->isNotEmpty())
                        {{ $enrollmentsByTerm->first()['enrollments']->first()->course->program->program_name }}
                        @else
                        N/A
                        @endif
                    </div>
                    <div class="stat-label">Program</div>
                </div>
            </div>
        </div>
    </div>
</x-studentapp-layout>