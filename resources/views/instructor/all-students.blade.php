<x-instructorapp-layout>
    <x-slot name="title">All Students</x-slot>

    <div class="dashboard">
        <div class="dashboard-header">
            <h1 class="dashboard-title">All My Students</h1>
            <p class="dashboard-subtitle">Complete list of students enrolled in your courses</p>
        </div>

        <!-- Export Section -->
        <div class="add-export-container">
            <a href="{{ route('instructor.students.pdf') }}"
                class="module-action">
                <i class="fas fa-download"></i>
                Export PDF
            </a>
        </div>

        <!-- Students Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    Students Overview ({{ $students->count() }} Total)
                </h2>
            </div>

            <div class="card-body">
                @if($students->count() > 0)
                <!-- Students Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Student
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Student ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Enrolled Courses
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-600">
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
                                                {{ $student->first_name }} {{ $student->last_name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $student->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ $student->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @foreach($student->enrollments as $enrollment)
                                        <div class="flex items-center text-sm">
                                            <span class="font-medium">{{ $enrollment->schedule->course_code }}</span>
                                            <span class="mx-2 text-gray-400">•</span>
                                            <span>{{ $enrollment->schedule->course->course_name }}</span>
                                            <span class="ml-2 px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
                                                {{ $enrollment->schedule->section->section_name }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('instructor.student.cor', $student->id) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                            title="Download COR">
                                            <i class="fas fa-download"></i>
                                            COR
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <p>No students found in your courses</p>
                    <p class="text-sm">Students will appear here once they enroll in your classes.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Course Summary -->
        @if($students->count() > 0)
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Course Summary</h2>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                    $courseSummary = [];
                    foreach($students as $student) {
                    foreach($student->enrollments as $enrollment) {
                    $courseKey = $enrollment->schedule->course_code;
                    $sectionKey = $enrollment->schedule->section->section_name;

                    if (!isset($courseSummary[$courseKey])) {
                    $courseSummary[$courseKey] = [
                    'course_name' => $enrollment->schedule->course->course_name,
                    'sections' => []
                    ];
                    }

                    if (!isset($courseSummary[$courseKey]['sections'][$sectionKey])) {
                    $courseSummary[$courseKey]['sections'][$sectionKey] = 0;
                    }

                    $courseSummary[$courseKey]['sections'][$sectionKey]++;
                    }
                    }
                    @endphp

                    @foreach($courseSummary as $courseCode => $courseData)
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-2">{{ $courseCode }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $courseData['course_name'] }}</p>

                        <div class="space-y-2">
                            @foreach($courseData['sections'] as $sectionName => $studentCount)
                            <div class="flex justify-between items-center">
                                <span class="text-sm">{{ $sectionName }}</span>
                                <span class="px-2 py-1 bg-primary text-white text-xs rounded">
                                    {{ $studentCount }} student{{ $studentCount !== 1 ? 's' : '' }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</x-instructorapp-layout>