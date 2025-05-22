<x-studentapp-layout>
    <x-slot name="title">
        Enroll in Courses
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Course Selection</div>
        <div class="dashboard-subtitle">Select your courses for {{ $currentTerm->schoolyear_semester }}</div>
    </div>

    <div class="mb-6">
        <a href="{{ route('studentSide.enrollment.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to Enrollments
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Enrollment Form -->
    <form action="{{ route('studentSide.enrollment.store') }}" method="POST" id="enrollmentForm">
        @csrf
        <input type="hidden" name="term_id" value="{{ $currentTerm->id }}">
        <input type="hidden" name="program_id" value="{{ $programId }}">

        <!-- Year Level Selection -->
        <div class="card mb-6">
            <div class="card-header">
                <div class="card-title">Year Level Selection</div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="year_level" class="block text-sm font-medium text-gray-700">Select Your Year Level</label>
                        <select name="year_level" id="year_level" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                            @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ $yearLevel == $i ? 'selected' : '' }}>Year {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Selection -->
        <div class="card mb-6">
            <div class="card-header">
                <div class="card-title">Section Selection</div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="section_id" class="block text-sm font-medium text-gray-700">Select Your Section</label>
                        <select name="section_id" id="section_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                            <option value="">-- Select Section --</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-6">
            <div class="card-header">
                <div class="card-title">Program Courses - {{ $studentProgram->program_name ?? 'Selected Program' }}</div>
                <div class="card-subtitle">Year <span id="selected_year">{{ $yearLevel }}</span></div>
            </div>
            <div class="card-body">
                <div id="courses_container">
                    @if($programCourses->isEmpty() && $genEdCourses->isEmpty())
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No courses found for this program and year level
                        </div>
                    @else
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
                                @foreach($programCourses as $course)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3">
                                            <input type="checkbox" name="course_codes[]" id="course_{{ $course->course_code }}" 
                                                value="{{ $course->course_code }}" class="course-checkbox rounded border-gray-300 dark:border-gray-600
                                                focus:ring-primary-500 text-primary-600">
                                        </td>
                                        <td class="px-4 py-3">{{ $course->course_code }}</td>
                                        <td class="px-4 py-3">{{ $course->course_name }}</td>
                                        <td class="px-4 py-3">{{ $course->credits }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                Program-specific
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <select name="schedule_ids[{{ $course->course_code }}]" id="schedule_{{ $course->course_code }}" 
                                                class="schedule-select w-full py-1 text-sm border border-gray-300 dark:border-gray-600 
                                                dark:bg-gray-700 rounded focus:ring-primary-500 focus:border-primary-500" disabled>
                                                <option value="">Select Schedule</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($genEdCourses->isNotEmpty())
                                    @foreach($genEdCourses as $course)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3">
                                                <input type="checkbox" name="course_codes[]" id="course_{{ $course->course_code }}" 
                                                    value="{{ $course->course_code }}" class="course-checkbox rounded border-gray-300 dark:border-gray-600
                                                    focus:ring-primary-500 text-primary-600">
                                            </td>
                                            <td class="px-4 py-3">{{ $course->course_code }}</td>
                                            <td class="px-4 py-3">{{ $course->course_name }}</td>
                                            <td class="px-4 py-3">{{ $course->credits }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                    General Education
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="schedule_ids[{{ $course->course_code }}]" id="schedule_{{ $course->course_code }}" 
                                                    class="schedule-select w-full py-1 text-sm border border-gray-300 dark:border-gray-600 
                                                    dark:bg-gray-700 rounded focus:ring-primary-500 focus:border-primary-500" disabled>
                                                    <option value="">Select Schedule</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="btn-primary" id="submitBtn">
                <i class="fas fa-save mr-2"></i> Submit Enrollment
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yearLevelSelect = document.getElementById('year_level');
            const sectionSelect = document.getElementById('section_id');
            const coursesContainer = document.getElementById('courses_container');
            const selectedYearSpan = document.getElementById('selected_year');
            const programId = '{{ $programId }}';

            // Function to load sections for the selected program
            // Replace the loadSections() function with this:
function initializeSections() {
    // Check if we already have server-side loaded sections
    if (sectionSelect.options.length > 1) {
        console.log('Using server-side loaded sections');
        return;
    }
    
    // Fallback to AJAX loading if no server-side sections
    console.log('Loading sections via AJAX for program:', programId);
    fetch(`/api/sections-by-program?program_id=${programId}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(sections => {
            console.log('Sections received:', sections);
            
            if (sections && sections.length > 0) {
                console.log('Populating sections dropdown with', sections.length, 'sections');
                sections.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.section_name;
                    sectionSelect.appendChild(option);
                });
                sectionSelect.disabled = false;
            } else {
                console.log('No sections found for program:', programId);
                sectionSelect.innerHTML = '<option value="">No sections available</option>';
                sectionSelect.disabled = true;
            }
        })
        .catch(error => {
            console.error('Error loading sections:', error);
            sectionSelect.innerHTML = '<option value="">Error loading sections</option>';
            sectionSelect.disabled = true;
        });
}

// Replace the initial load with:
console.log('Initializing with program ID:', programId);
initializeSections();

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

    fetch(`/api/schedules-by-course-section?course_code=${courseCode}&section_id=${sectionId}`) 
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(schedules => {
            // Always include a "No Schedule" option first
            scheduleSelect.innerHTML = `
                <option value="">No Schedule (Optional)</option>
                ${schedules.map(schedule => {
                    let startTime = 'N/A';
                    let endTime = 'N/A';

                    try {
                        if (schedule.starting_time) {
                            startTime = new Date(`2000-01-01T${schedule.starting_time}`)
                                .toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        }
                        if (schedule.ending_time) {
                            endTime = new Date(`2000-01-01T${schedule.ending_time}`)
                                .toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        }
                    } catch (e) {
                        console.error('Error parsing times:', e);
                    }

                    const instructorName = schedule.instructor ?
                        `${schedule.instructor.last_name || ''}, ${schedule.instructor.first_name || ''}`.trim() :
                        'No Instructor';

                    const roomName = schedule.room ? (schedule.room.roomname || 'Unnamed Room') : 'No Room';
                    const dayInfo = schedule.day || 'No Day Set';

                    return `<option value="${schedule.id}">
                        ${dayInfo}: ${startTime}-${endTime} | ${instructorName} | ${roomName}
                    </option>`;
                }).join('')}
            `;
        })
        .catch(error => {
            console.error('Error loading schedules:', error);
            scheduleSelect.innerHTML = '<option value="">Error loading schedules</option>';
        });
}
            }

            // Initial load
            console.log('Initial load with program ID:', programId);
            loadSections();

            // Event listeners
            yearLevelSelect.addEventListener('change', function() {
                console.log('Year level changed to:', this.value);
                window.location.href = `{{ route('studentSide.enrollment.create') }}?program_id=${programId}&year_level=${this.value}`;
            });

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

            // Add event listeners to checkboxes
            document.querySelectorAll('.course-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const courseCode = this.value;
                    const scheduleSelect = document.getElementById(`schedule_${courseCode}`);
                    if (scheduleSelect) {
                        scheduleSelect.disabled = !this.checked;
                        if (!this.checked) {
                            scheduleSelect.value = '';
                        } else if (sectionSelect.value) {
                            loadSchedulesForCourse(courseCode);
                        }
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

            // Add form validation
            document.getElementById('enrollmentForm').addEventListener('submit', function(event) {
                const selectedCourses = document.querySelectorAll('.course-checkbox:checked');
                const sectionId = document.getElementById('section_id').value;

                if (selectedCourses.length === 0) {
                    event.preventDefault();
                    alert('Please select at least one course to enroll.');
                    return false;
                }

                if (!sectionId) {
                    event.preventDefault();
                    alert('Please select a section.');
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

                // Disable submit button to prevent double submission
                document.getElementById('submitBtn').disabled = true;
            });
        });

        document.getElementById('enrollmentForm').addEventListener('submit', function(event) {
    const selectedCourses = document.querySelectorAll('.course-checkbox:checked');
    const sectionId = document.getElementById('section_id').value;
    let hasScheduleError = false;

    if (selectedCourses.length === 0) {
        event.preventDefault();
        alert('Please select at least one course to enroll.');
        return false;
    }

    if (!sectionId) {
        event.preventDefault();
        alert('Please select a section.');
        return false;
    }

    // Check each selected course has a schedule if options exist
    selectedCourses.forEach(checkbox => {
        const courseCode = checkbox.value;
        const scheduleSelect = document.getElementById(`schedule_${courseCode}`);
        
        // If there are schedule options (more than just the "No Schedule" option)
        if (scheduleSelect.options.length > 1 && !scheduleSelect.value) {
            hasScheduleError = true;
        }
    });

    if (hasScheduleError) {
        event.preventDefault();
        alert('Please select schedules for all courses that have available schedules.');
        return false;
    }

    // Disable submit button to prevent double submission
    document.getElementById('submitBtn').disabled = true;
});
    </script>
    @endpush
</x-studentapp-layout>