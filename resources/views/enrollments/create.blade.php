<x-app-layout>
    <x-slot name="title">
        Create Enrollment
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Create New Enrollment</div>
        <div class="dashboard-subtitle">Add a new student course enrollment to the system</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex mb-6">
            <a href="{{ route('enrollments.index') }}" class="px-4 py-2 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Enrollments
            </a>
        </div>

        <div class="module-card">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900 dark:text-red-200">
                    <p class="font-bold">Please fix the following errors:</p>
                    <ul class="ml-4 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('enrollments.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Student Selection -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium mb-2">Student</label>
                        <select name="student_id" id="student_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->last_name }}, {{ $student->first_name }} (ID: {{ $student->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Term Selection -->
                    <div>
                        <label for="term_id" class="block text-sm font-medium mb-2">Term</label>
                        <select name="term_id" id="term_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Term</option>
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}" {{ old('term_id') == $term->id ? 'selected' : '' }}>
                                    {{ $term->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Selection -->
                    <div>
                        <label for="course_code" class="block text-sm font-medium mb-2">Course</label>
                        <select name="course_code" id="course_code" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_code }}" {{ old('course_code') == $course->course_code ? 'selected' : '' }}>
                                    {{ $course->course_code }} - {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section Selection -->
                    <div>
                        <label for="section_id" class="block text-sm font-medium mb-2">Section</label>
                        <select name="section_id" id="section_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Schedule Selection -->
                    <div>
                        <label for="schedule_id" class="block text-sm font-medium mb-2">Schedule</label>
                        <select name="schedule_id" id="schedule_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Schedule</option>
                            @foreach($schedules as $schedule)
                                <option value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                    {{ $schedule->day }} | 
                                    {{ \Carbon\Carbon::parse($schedule->starting_time)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($schedule->ending_time)->format('h:i A') }} | 
                                    {{ $schedule->course->course_code ?? 'N/A' }} | 
                                    {{ $schedule->section->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Level -->
                    <div>
                        <label for="year_level" class="block text-sm font-medium mb-2">Year Level</label>
                        <select name="year_level" id="year_level" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Year Level</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('year_level') == $i ? 'selected' : '' }}>
                                    Year {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        Create Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courseCodeSelect = document.getElementById('course_code');
            const scheduleSelect = document.getElementById('schedule_id');
            const sectionSelect = document.getElementById('section_id');
            
            // Filter schedules when course changes
            courseCodeSelect.addEventListener('change', function() {
                const selectedCourse = this.value;
                
                // Reset options
                for (let i = 0; i < scheduleSelect.options.length; i++) {
                    scheduleSelect.options[i].style.display = '';
                }
                
                // Hide non-matching options
                if (selectedCourse) {
                    for (let i = 1; i < scheduleSelect.options.length; i++) {
                        const option = scheduleSelect.options[i];
                        if (option.text.indexOf(selectedCourse) === -1) {
                            option.style.display = 'none';
                        }
                    }
                }
                
                // Reset selection if currently selected option is now hidden
                if (scheduleSelect.selectedIndex > 0 && 
                    scheduleSelect.options[scheduleSelect.selectedIndex].style.display === 'none') {
                    scheduleSelect.selectedIndex = 0;
                }
            });
            
            // Trigger initial filtering if course is already selected
            if (courseCodeSelect.value) {
                courseCodeSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>