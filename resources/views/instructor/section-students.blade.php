<x-instructorapp-layout>
    <x-slot name="title">{{ $section->section_name }} - Students</x-slot>

    <div class="dashboard">
        <!-- Page Header -->
        <div class="dashboard-header">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="dashboard-title">{{ $section->section_name }} Students</h1>
                    <p class="dashboard-subtitle">
                        {{ $section->program->program_name }} - {{ $section->program->department->department_name }}
                    </p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('instructor.dashboard') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <a href="{{ route('instructor.section.students.pdf', $section->id) }}" class="btn-primary">
                        <i class="fas fa-download"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $students->count() }}</div>
                <div class="stat-label">Total Students</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <div class="stat-value">
                    @if($students->count() > 0)
                    {{ number_format($students->avg(function($student) {
                            return $student->enrollments->count();
                        }), 1) }}
                    @else
                    0
                    @endif
                </div>
                <div class="stat-label">Avg Courses per Student</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon purple">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $section->section_name }}</div>
                <div class="stat-label">Section</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon orange">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
                <div class="stat-value">
                    @if($students->count() > 0)
                    {{ number_format($students->avg(function($student) {
                            return $student->enrollments->sum(function($enrollment) {
                                return $enrollment->schedule->course->credits;
                            });
                        }), 1) }}
                    @else
                    0
                    @endif
                </div>
                <div class="stat-label">Avg Units per Student</div>
            </div>
        </div>

        <!-- Students List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Students List</h3>
                <span class="record-count">{{ $students->count() }} student(s)</span>
            </div>

            @if($students->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Student Info
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Student ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Enrolled Courses
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total Units
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Terms
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($students as $student)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="avatar">
                                        @if($student->user->avatar)
                                        <img src="{{ asset('storage/' . $student->user->avatar) }}" alt="Profile" class="avatar-image">
                                        @else
                                        <i class="fas fa-user"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium">
                                            {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $student->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded text-xs">
                                    {{ $student->id }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1 max-h-32 overflow-y-auto">
                                    @foreach($student->enrollments as $enrollment)
                                    <div class="text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">
                                        <strong>{{ $enrollment->schedule->course->course_code }}</strong> -
                                        {{ $enrollment->schedule->course->course_name }}
                                        <div class="text-gray-500 mt-1">
                                            <i class="fas fa-calendar"></i> {{ $enrollment->schedule->day }}
                                            {{ Carbon\Carbon::parse($enrollment->schedule->starting_time)->format('g:i A') }}-{{ Carbon\Carbon::parse($enrollment->schedule->ending_time)->format('g:i A') }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="font-semibold">
                                    {{ $student->enrollments->sum(function($enrollment) {
                                        return $enrollment->schedule->course->credits;
                                    }) }} Units
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    @foreach($student->enrollments->groupBy('term.schoolyear_semester') as $termSemester => $termEnrollments)
                                    <div class="text-xs">
                                        <span class="bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 px-2 py-1 rounded">
                                            {{ $termSemester }}
                                        </span>
                                        <span class="text-gray-500 ml-1">
                                            ({{ $termEnrollments->count() }} course{{ $termEnrollments->count() > 1 ? 's' : '' }})
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('instructor.student.cor', $student->id) }}"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                        title="Download COR">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
                <p>No students found in this section.</p>
                <a href="{{ route('instructor.dashboard') }}" class="btn-outline">
                    Back to Dashboard
                </a>
            </div>
            @endif
        </div>

        <!-- Section Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Section Details</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 add-gap">
                    <div>
                        <label class="block text-sm font-medium mb-2">Section Name</label>
                        <p class="text-sm bg-gray-100 dark:bg-gray-800 p-3 rounded">{{ $section->section_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Program</label>
                        <p class="text-sm bg-gray-100 dark:bg-gray-800 p-3 rounded">{{ $section->program->program_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Department</label>
                        <p class="text-sm bg-gray-100 dark:bg-gray-800 p-3 rounded">{{ $section->program->department->department_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Total Enrolled Students</label>
                        <p class="text-sm bg-gray-100 dark:bg-gray-800 p-3 rounded">{{ $students->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms Breakdown -->
        @if($students->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Enrollment by Terms</h3>
            </div>
            <div class="card-body">
                @php
                $allEnrollments = $students->flatMap->enrollments;
                $enrollmentsByTerm = $allEnrollments->groupBy('term.schoolyear_semester');
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($enrollmentsByTerm as $termSemester => $termEnrollments)
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded">
                        <h4 class="font-semibold text-sm mb-2">{{ $termSemester }}</h4>
                        <div class="space-y-1 text-xs">
                            <div class="flex justify-between">
                                <span>Students:</span>
                                <span class="font-medium">{{ $termEnrollments->unique('student_id')->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Enrollments:</span>
                                <span class="font-medium">{{ $termEnrollments->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total Units:</span>
                                <span class="font-medium">
                                    {{ $termEnrollments->sum(function($enrollment) {
                                            return $enrollment->schedule->course->credits;
                                        }) }}
                                </span>
                            </div>
                            @if($termEnrollments->first()->term->status)
                            <div class="flex justify-between">
                                <span>Status:</span>
                                <span class="inline-flex items-center px-1 py-0.5 rounded text-xs 
                                        {{ $termEnrollments->first()->term->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                    {{ ucfirst($termEnrollments->first()->term->status) }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        function viewStudentDetails(studentId) {
            // You can implement a modal or redirect to detailed view
            console.log('Viewing details for student:', studentId);

            // For now, let's create a simple alert with student info
            // In a real implementation, you might open a modal or navigate to a detailed page
            alert('Student details functionality - Student ID: ' + studentId);
        }

        // Optional: Add filtering functionality
        function filterByTerm(termId) {
            // This could be implemented to filter the current table
            console.log('Filtering by term:', termId);
        }

        // Optional: Add search functionality
        function searchStudents() {
            const searchInput = document.getElementById('student-search');
            const searchTerm = searchInput.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                const studentName = row.querySelector('td:first-child .text-sm.font-medium').textContent.toLowerCase();
                const studentId = row.querySelector('.bg-blue-100').textContent.toLowerCase();

                if (studentName.includes(searchTerm) || studentId.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</x-instructorapp-layout>