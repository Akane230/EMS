<x-studentapp-layout>
    <x-slot name="title">
        Current Term Enrollments
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Current Term Enrollments</div>
        <div class="dashboard-subtitle">{{ $currentTerm->schoolyear_semester }}</div>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-6 border-l-4 border-green-500 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="px-4 py-3 mb-6 border-l-4 border-red-500 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
        {{ session('error') }}
    </div>
    @endif

    <div class="flex items-center space-x-4 add-export-container">
        <a href="{{ route('student.enrollment.create') }}" class="module-action">
            Enroll in New Course <i class="fas fa-plus ml-2"></i>
        </a>
        <a href="{{ route('student.enrollment.download.cor') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
            <i class="fas fa-file-pdf mr-2"></i> Download COR
        </a>
        <a href="{{ route('student.enrollment.index') }}" class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
            <i class="fas fa-list mr-2"></i> All Enrollments
        </a>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            @if($isEnrolled)
            <div class="mb-6">
                <div class="flex items-center space-x-1 mb-4">
                    <div class="h-4 w-4 bg-primary rounded-full"></div>
                    <h3 class="text-xl font-semibold">Term Summary</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <div class="text-sm uppercase text-gray-500 dark:text-gray-400">Total Courses</div>
                        <div class="text-2xl font-bold mt-1">{{ $enrolledCourses }}</div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <div class="text-sm uppercase text-gray-500 dark:text-gray-400">Year Level</div>
                        <div class="text-2xl font-bold mt-1">Year {{ $enrollments->first()->year_level ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Today's Classes -->
            @if($todayClasses->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-lg font-medium mb-4">Today's Classes</h3>
                <div class="space-y-4">
                    @foreach($todayClasses as $class)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border-l-4 border-primary">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium">{{ $class->course->course_name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $class->course->course_code }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $class->section->section_name ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="mt-3 flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-clock mr-2"></i>
                            {{ $class->formatted_start_time }} - {{ $class->formatted_end_time }}
                        </div>
                        <div class="mt-1 flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $class->room->roomname ?? 'N/A' }}
                        </div>
                        <div class="mt-1 flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-user-tie mr-2"></i>
                            @if($class->instructor)
                            {{ $class->instructor->last_name }}, {{ $class->instructor->first_name }}
                            @else
                            Not assigned
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- All Enrollments Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Units</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Section</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Schedule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Instructor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach ($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                {{ $enrollment->course_code }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $enrollment->course->course_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $enrollment->course->credits ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $enrollment->section->section_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($enrollment->schedule)
                                {{ $enrollment->schedule->day ?? 'N/A' }},
                                {{ $enrollment->schedule->formatted_start_time ?? 'N/A' }} -
                                {{ $enrollment->schedule->formatted_end_time ?? 'N/A' }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $enrollment->schedule->room->roomname ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($enrollment->schedule && $enrollment->schedule->instructor)
                                {{ $enrollment->schedule->instructor->last_name }}, {{ $enrollment->schedule->instructor->first_name }}
                                @else
                                N/A
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-10">
                <div class="text-5xl text-gray-300 dark:text-gray-600 mb-4">
                    <i class="fas fa-school"></i>
                </div>
                <h3 class="text-xl font-medium mb-2">No Current Enrollments</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">You are not enrolled in any courses for the current term.</p>
                <a href="{{ route('student.enrollment.create') }}" class="module-action">
                    Enroll Now <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Remove success/error messages after 3 seconds
            const messages = document.querySelectorAll('[class*="border-green-500"], [class*="border-red-500"]');
            if (messages.length > 0) {
                setTimeout(function() {
                    messages.forEach(message => message.remove());
                }, 3000);
            }
        });
    </script>
</x-studentapp-layout>