<x-app-layout>
    <x-slot name="title">
        Edit Enrollment
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Edit Enrollment</div>
        <div class="dashboard-subtitle">Update enrollment information for {{ $enrollment->student->first_name ?? '' }} {{ $enrollment->student->last_name ?? '' }}</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center space-x-4 add-export-container">
            <a href="{{ route('enrollments.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
        </div>

        <div class="module-card">
            @if ($errors->any())
                <div class="mb-4 px-4 py-2 border-l-4 border-red-500 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Student Selection -->
                    <div class="mb-4">
                        <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Student</label>
                        <select id="student_id" name="student_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $enrollment->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->last_name }}, {{ $student->first_name }} (ID: {{ $student->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Term Selection -->
                    <div class="mb-4">
                        <label for="term_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Term</label>
                        <select id="term_id" name="term_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Term</option>
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}" {{ $enrollment->term_id == $term->id ? 'selected' : '' }}>
                                    {{ $term->schoolyear_semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Course Selection -->
                    <div class="mb-4">
                        <label for="course_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course</label>
                        <select id="course_code" name="course_code" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_code }}" {{ $enrollment->course_code == $course->course_code ? 'selected' : '' }}>
                                    {{ $course->course_code }}: {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Section Selection -->
                    <div class="mb-4">
                        <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Section</label>
                        <select id="section_id" name="section_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ $enrollment->section_id == $section->id ? 'selected' : '' }}>
                                    {{ $section->section_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Schedule Selection -->
                    <div class="mb-4">
                        <label for="schedule_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Schedule</label>
                        <select id="schedule_id" name="schedule_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Schedule</option>
                            @foreach($schedules as $schedule)
                                <option value="{{ $schedule->id }}" {{ $enrollment->schedule_id == $schedule->id ? 'selected' : '' }}>
                                    {{ $schedule->day }} {{ \Carbon\Carbon::parse($schedule->starting_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->ending_time)->format('h:i A') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Year Level -->
                    <div class="mb-4">
                        <label for="year_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year Level</label>
                        <select id="year_level" name="year_level" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Year Level</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $enrollment->year_level == $i ? 'selected' : '' }}>
                                    Year {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('enrollments.show', $enrollment->id) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        Update Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Example of dynamic loading of sections based on course selection
            const courseSelect = document.getElementById('course_code');
            const sectionSelect = document.getElementById('section_id');
            
            courseSelect.addEventListener('change', function() {
                const courseCode = this.value;
                if (courseCode) {
                    // In a real application, you might want to fetch sections for this course
                    // via AJAX and update the section dropdown
                    // This is just a placeholder for that functionality
                    console.log('Course changed:', courseCode);
                }
            });
            
            // Example of dynamic loading of schedules based on section selection
            const sectionSelectElem = document.getElementById('section_id');
            const scheduleSelect = document.getElementById('schedule_id');
            
            sectionSelectElem.addEventListener('change', function() {
                const sectionId = this.value;
                if (sectionId) {
                    // In a real application, you might want to fetch schedules for this section
                    // via AJAX and update the schedule dropdown
                    // This is just a placeholder for that functionality
                    console.log('Section changed:', sectionId);
                }
            });
        });
    </script>
</x-app-layout>