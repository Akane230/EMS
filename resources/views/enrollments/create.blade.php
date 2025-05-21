<x-app-layout>
    <x-slot name="title">
        Bulk Enrollment
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Bulk Course Enrollment</div>
        <div class="dashboard-subtitle">Enroll students in multiple courses at once based on program</div>
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

            <form action="{{ route('enrollments.store.bulk') }}" method="POST" id="bulkEnrollmentForm">
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

                    <!-- Section Selection -->
                    <div>
                        <label for="section_id" class="block text-sm font-medium mb-2">Section *</label>
                        <select name="section_id" id="section_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required disabled>
                            <option value="">Select Section</option>
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
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-4">Available Courses</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Select the courses to enroll this student in. Course selection will be available after choosing a program.
                    </p>

                    <div id="courseLoadContainer" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            Select a program to view available courses
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        Complete Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Updated script for create-bulk.blade.php - Fixed schedule loading issue
        document.addEventListener('DOMContentLoaded', function() {
            const programSelect = document.getElementById('program_id');
            const sectionSelect = document.getElementById('section_id');
            const courseLoadContainer = document.getElementById('courseLoadContainer');
            const yearLevelSelect = document.getElementById('year_level');

            // When program changes, fetch the related sections and courses
            programSelect.addEventListener('change', function() {
                const programId = this.value;

                if (!programId) {
                    // Reset the container if no program selected
                    courseLoadContainer.innerHTML = `
                <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                    Select a program to view available courses
                </div>
            `;

                    // Reset and disable section dropdown
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    sectionSelect.disabled = true;
                    return;
                }

                // Show loading indicator
                courseLoadContainer.innerHTML = `
            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                <i class="fas fa-spinner fa-spin mr-2"></i> Loading courses...
            </div>
        `;

                // Fetch sections for the selected program
                fetch(`/api/admin/sections-by-program?program_id=${programId}`)
                    .then(response => response.json())
                    .then(sections => {
                        sectionSelect.innerHTML = '<option value="">Select Section</option>';

                        sections.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.section_name;
                            sectionSelect.appendChild(option);
                        });

                        sectionSelect.disabled = false;
                    });

                // Fetch courses for the selected program (including general education courses)
                fetch(`/api/admin/courses-by-program?program_id=${programId}&year_level=${yearLevelSelect.value}`)
                    .then(response => response.json())
                    .then(courses => {
                        if (courses.length === 0) {
                            courseLoadContainer.innerHTML = `
                                <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                    No courses found for this program and year level
                                </div>
                            `;
                            return;
                        }

                        // Create the course checklist
                        let coursesHTML = `
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left">Select</th>
                                        <th class="px-4 py-2 text-left">Course Code</th>
                                        <th class="px-4 py-2 text-left">Course Name</th>
                                        <th class="px-4 py-2 text-left">Credits</th>
                                        <th class="px-4 py-2 text-left">Category</th>
                                        <th class="px-4 py-2 text-left">Schedule</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        `;

                        // Group courses by program (for visual distinction)
                        const coursesByProgram = {};

                        courses.forEach(course => {
                            if (!coursesByProgram[course.program_id]) {
                                coursesByProgram[course.program_id] = [];
                            }
                            coursesByProgram[course.program_id].push(course);
                        });

                        // First add the selected program's courses
                        const mainProgramCourses = coursesByProgram[programId] || [];

                        mainProgramCourses.forEach(course => {
                            coursesHTML += generateCourseRow(course, 'Program-specific');
                        });

                        // Then add general education courses (if any)
                        Object.keys(coursesByProgram).forEach(programId => {
                            if (programId != programSelect.value) {
                                // This should be general education courses
                                coursesByProgram[programId].forEach(course => {
                                    coursesHTML += generateCourseRow(course, 'General Education');
                                });
                            }
                        });

                        coursesHTML += `
                        </tbody>
                    </table>
                    <div class="mt-4 flex items-center">
                        <button type="button" id="selectAllBtn" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 mr-2">
                            Select All
                        </button>
                        <button type="button" id="clearAllBtn" class="px-3 py-1 bg-gray-600 text-white text-xs rounded hover:bg-gray-700">
                            Clear All
                        </button>
                    </div>
                `;

                        courseLoadContainer.innerHTML = coursesHTML;

                        // Add event listeners to checkboxes
                        document.querySelectorAll('.course-checkbox').forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                const courseCode = this.value;
                                const scheduleSelect = document.getElementById(`schedule_${courseCode}`);

                                if (this.checked) {
                                    scheduleSelect.disabled = false;

                                    if (sectionSelect.value) {
                                        loadSchedulesForCourse(courseCode);
                                    } else {
                                        scheduleSelect.innerHTML = '<option value="">Select a section first</option>';
                                    }
                                } else {
                                    scheduleSelect.disabled = true;
                                }
                            });
                        });

                        // Add "Select All" button functionality
                        document.getElementById('selectAllBtn').addEventListener('click', function() {
                            document.querySelectorAll('.course-checkbox').forEach(checkbox => {
                                checkbox.checked = true;
                                const event = new Event('change');
                                checkbox.dispatchEvent(event);
                            });
                        });

                        // Add "Clear All" button functionality
                        document.getElementById('clearAllBtn').addEventListener('click', function() {
                            document.querySelectorAll('.course-checkbox').forEach(checkbox => {
                                checkbox.checked = false;
                                const event = new Event('change');
                                checkbox.dispatchEvent(event);
                            });
                        });
                    });
            });

            // Function to generate course row HTML
            function generateCourseRow(course, categoryLabel) {
                return `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3">
                            <input type="checkbox" name="course_codes[]" id="course_${course.course_code}" 
                                value="${course.course_code}" class="course-checkbox rounded border-gray-300 dark:border-gray-600
                                focus:ring-primary-500 text-primary-600">
                        </td>
                        <td class="px-4 py-3">${course.course_code}</td>
                        <td class="px-4 py-3">${course.course_name}</td>
                        <td class="px-4 py-3">${course.credits}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-${categoryLabel === 'General Education' ? 'green' : 'blue'}-100 
                            text-${categoryLabel === 'General Education' ? 'green' : 'blue'}-800 text-xs rounded-full">
                                ${categoryLabel}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <select name="schedule_ids[${course.course_code}]" id="schedule_${course.course_code}" 
                                class="schedule-select w-full py-1 text-sm border border-gray-300 dark:border-gray-600 
                                dark:bg-gray-700 rounded focus:ring-primary-500 focus:border-primary-500" disabled>
                                <option value="">Select Schedule</option>
                            </select>
                        </td>
                    </tr>
                `;
            }

            // When section changes, reload schedules for selected courses
            sectionSelect.addEventListener('change', function() {
                if (this.value) {
                    document.querySelectorAll('.course-checkbox:checked').forEach(checkbox => {
                        loadSchedulesForCourse(checkbox.value);
                    });
                } else {
                    document.querySelectorAll('.schedule-select').forEach(select => {
                        select.innerHTML = '<option value="">Select a section first</option>';
                    });
                }
            });

            // Function to load schedules for a specific course
            function loadSchedulesForCourse(courseCode) {
                const sectionId = sectionSelect.value;
                const scheduleSelect = document.getElementById(`schedule_${courseCode}`);

                if (!sectionId) {
                    scheduleSelect.innerHTML = '<option value="">Select a section first</option>';
                    return;
                }

                scheduleSelect.innerHTML = '<option value="">Loading schedules...</option>';
                scheduleSelect.disabled = false;

                fetch(`/api/admin/schedules-by-course-section?course_code=${courseCode}&section_id=${sectionId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(schedules => {
                        scheduleSelect.innerHTML = '<option value="">Select Schedule</option>';

                        if (!schedules || schedules.length === 0) {
                            scheduleSelect.innerHTML = '<option value="">No schedules available</option>';
                            return;
                        }

                        schedules.forEach(schedule => {
                            const option = document.createElement('option');
                            option.value = schedule.id;

                            let startTime = 'N/A';
                            let endTime = 'N/A';

                            if (schedule.starting_time) {
                                try {
                                    startTime = new Date(`2000-01-01T${schedule.starting_time}`)
                                        .toLocaleTimeString([], {
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        });
                                } catch (e) {
                                    console.error('Error parsing start time:', e);
                                }
                            }

                            if (schedule.ending_time) {
                                try {
                                    endTime = new Date(`2000-01-01T${schedule.ending_time}`)
                                        .toLocaleTimeString([], {
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        });
                                } catch (e) {
                                    console.error('Error parsing end time:', e);
                                }
                            }

                            const instructorName = schedule.instructor ?
                                `${schedule.instructor.last_name || ''}, ${schedule.instructor.first_name || ''}`.trim() :
                                'No Instructor';

                            const roomName = schedule.room ? (schedule.room.roomname || 'Unnamed Room') : 'No Room';

                            const dayInfo = schedule.day || 'No Day Set';
                            option.textContent = `${dayInfo}: ${startTime}-${endTime} | ${instructorName} | ${roomName}`;

                            scheduleSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading schedules:', error);
                        scheduleSelect.innerHTML = '<option value="">Error loading schedules</option>';
                    });
            }

            // Validate form before submission
            document.getElementById('bulkEnrollmentForm').addEventListener('submit', function(event) {
                const selectedCourses = document.querySelectorAll('.course-checkbox:checked');

                if (selectedCourses.length === 0) {
                    event.preventDefault();
                    alert('Please select at least one course to enroll.');
                    return false;
                }

                // Check if schedules are selected for each checked course
                let missingSchedule = false;
                selectedCourses.forEach(checkbox => {
                    const courseCode = checkbox.value;
                    const scheduleSelect = document.getElementById(`schedule_${courseCode}`);

                    if (!scheduleSelect.value && scheduleSelect.options.length > 1) {
                        missingSchedule = true;
                    }
                });

                if (missingSchedule) {
                    if (!confirm('Some courses do not have schedules selected. Do you want to continue anyway?')) {
                        event.preventDefault();
                        return false;
                    }
                }
            });
        });
    </script>
</x-app-layout>