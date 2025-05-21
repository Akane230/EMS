<x-app-layout>
    <x-slot name="title">
        Create Enrollment
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Create New Enrollment</div>
        <div class="dashboard-subtitle">Add multiple course enrollments for a student</div>
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Student Selection -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium mb-2">Student *</label>
                        <select name="student_id" id="student_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->last_name }}, {{ $student->first_name }} (ID: {{ $student->id }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Program Selection -->
                    <div>
                        <label for="program_id" class="block text-sm font-medium mb-2">Program *</label>
                        <select name="program_id" id="program_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Program</option>
                            @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->program_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Term Selection -->
                    <div>
                        <label for="term_id" class="block text-sm font-medium mb-2">Term *</label>
                        <select name="term_id" id="term_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Term</option>
                            @foreach($terms as $term)
                            <option value="{{ $term->id }}" {{ old('term_id') == $term->id ? 'selected' : '' }}>
                                {{ $term->schoolyear_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Level -->
                    <div>
                        <label for="year_level" class="block text-sm font-medium mb-2">Year Level *</label>
                        <select name="year_level" id="year_level" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Year Level</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('year_level') == $i ? 'selected' : '' }}>
                                Year {{ $i }}
                                </option>
                                @endfor
                        </select>
                    </div>

                    <!-- Section Selection -->
                    <div>
                        <label for="section_id" class="block text-sm font-medium mb-2">Section *</label>
                        <select name="section_id" id="section_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->id }}"
                                data-program="{{ $section->program_id }}"
                                {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->section_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Course Selection -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-4">Course Selection *</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="courses-container">
                            @foreach($courses as $course)
                            <div class="flex items-center">
                                <input type="checkbox"
                                    id="course_{{ $course->course_code }}"
                                    name="course_codes[]"
                                    value="{{ $course->course_code }}"
                                    class="course-checkbox h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded"
                                    data-program="{{ $course->program_id }}"
                                    {{ is_array(old('course_codes')) && in_array($course->course_code, old('course_codes')) ? 'checked' : '' }}>
                                <label for="course_{{ $course->course_code }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    {{ $course->course_code }} - {{ $course->course_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Schedule Selection -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-4">Schedule Selection</h3>
                    <div id="schedules-container">
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            Select courses first to view available schedules
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        Enroll Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // In the scripts section of create.blade.php, replace the current JavaScript with:

        document.addEventListener('DOMContentLoaded', function() {
            const programSelect = document.getElementById('program_id');
            const sectionSelect = document.getElementById('section_id');
            const courseCheckboxes = document.querySelectorAll('.course-checkbox');
            const coursesContainer = document.getElementById('courses-container');
            const schedulesContainer = document.getElementById('schedules-container');

            // Function to filter courses by program
            function filterCoursesByProgram(programId) {
                courseCheckboxes.forEach(checkbox => {
                    const courseProgram = checkbox.getAttribute('data-program');
                    const courseDiv = checkbox.closest('div');

                    if (!programId) {
                        // If no program selected, show all courses
                        courseDiv.style.display = 'flex';
                        return;
                    }

                    if (courseProgram === programId) {
                        courseDiv.style.display = 'flex';
                    } else {
                        courseDiv.style.display = 'none';
                        checkbox.checked = false;
                    }
                });
            }

            // Filter sections when program changes
            programSelect.addEventListener('change', function() {
                const selectedProgram = this.value;

                // Filter sections
                Array.from(sectionSelect.options).forEach(option => {
                    if (option.value === "") {
                        option.style.display = ''; // Always show the default option
                        return;
                    }

                    const programId = option.getAttribute('data-program');
                    if (!selectedProgram || programId === selectedProgram) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                        if (option.selected) {
                            sectionSelect.selectedIndex = 0; // Reset selection if current option is hidden
                        }
                    }
                });

                // Filter courses
                filterCoursesByProgram(selectedProgram);

                // Clear schedules when program changes
                schedulesContainer.innerHTML = `
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                Select courses and section to view available schedules
            </p>
        `;
            });

            // When courses are selected, show their schedules
            coursesContainer.addEventListener('change', function(e) {
                if (e.target.classList.contains('course-checkbox')) {
                    updateSchedulesDisplay();
                }
            });

            // When section changes, update schedules
            sectionSelect.addEventListener('change', updateSchedulesDisplay);

            function updateSchedulesDisplay() {
                const selectedCourses = Array.from(document.querySelectorAll('.course-checkbox:checked'))
                    .map(cb => cb.value);
                const sectionId = sectionSelect.value;

                if (selectedCourses.length === 0 || !sectionId) {
                    schedulesContainer.innerHTML = `
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Select courses and section to view available schedules
                </p>
            `;
                    return;
                }

                // Fetch schedules for selected courses and section
                fetch('/enrollments/schedules?section_id=' + sectionId + '&course_codes=' + selectedCourses.join(','))
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            schedulesContainer.innerHTML = `
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            No schedules available for selected courses and section
                        </p>
                    `;
                            return;
                        }

                        let html = '<div class="space-y-4">';
                        selectedCourses.forEach(courseCode => {
                            const courseSchedules = data.filter(s => s.course_code === courseCode);
                            if (courseSchedules.length > 0) {
                                const courseName = document.querySelector(`input[value="${courseCode}"]`)
                                    .nextElementSibling.textContent.split(' - ')[1];

                                html += `
                            <div class="schedule-group">
                                <h4 class="font-medium mb-2">${courseCode} - ${courseName}</h4>
                                <select name="schedule_ids[${courseCode}]" 
                                    class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Schedule</option>
                        `;

                                courseSchedules.forEach(schedule => {
                                    const timeFormat = schedule.starting_time + ' - ' + schedule.ending_time;
                                    html += `
                                <option value="${schedule.id}">
                                    ${schedule.day} | ${timeFormat} | ${schedule.room.room_number ?? 'N/A'} | ${schedule.instructor.last_name ?? 'N/A'}
                                </option>
                            `;
                                });

                                html += `</select></div>`;
                            }
                        });
                        html += '</div>';
                        schedulesContainer.innerHTML = html;
                    });
            }

            // Initialize filtering if program is already selected (from old input)
            if (programSelect.value) {
                filterCoursesByProgram(programSelect.value);

                // Also filter sections if program is selected
                Array.from(sectionSelect.options).forEach(option => {
                    if (option.value === "") return;
                    const programId = option.getAttribute('data-program');
                    if (programId !== programSelect.value) {
                        option.style.display = 'none';
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>