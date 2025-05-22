<x-studentapp-layout>
    <x-slot name="title">Enroll for {{ $currentTerm->schoolyear_semester }}</x-slot>

    <div class="dashboard-header">
        <h1 class="dashboard-title">Course Enrollment</h1>
        <p class="dashboard-subtitle">Enroll in courses for {{ $currentTerm->schoolyear_semester }}</p>
    </div>

    @if($errors->any())
        <div class="card" style="border-left: 4px solid var(--danger); margin-bottom: 20px;">
            <div class="card-body">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle" style="color: var(--danger); margin-right: 12px; font-size: 18px;"></i>
                    <div>
                        <h4 style="color: var(--danger); font-weight: 600; margin-bottom: 8px;">Please fix the following errors:</h4>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li style="color: var(--danger); margin-bottom: 4px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('studentSide.enrollment.store') }}" id="enrollmentForm" x-data="enrollmentForm()">
        @csrf
        <input type="hidden" name="term_id" value="{{ $currentTerm->id }}">
        <input type="hidden" name="year_level" :value="yearLevel">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-graduate" style="margin-right: 8px; color: var(--primary);"></i>
                    Student Information
                </h3>
            </div>
            <div class="card-body">
                <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div>
                        <label class="text-sm font-medium" style="color: var(--text-muted-light);">Student Name</label>
                        <p class="font-semibold">{{ $student->first_name }} {{ $student->last_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium" style="color: var(--text-muted-light);">Term</label>
                        <p class="font-semibold">{{ $currentTerm->schoolyear_semester }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium" style="color: var(--text-muted-light);">Status</label>
                        <p class="font-semibold">
                            @if($isFreshman)
                                <span style="color: var(--success);">
                                    <i class="fas fa-star" style="margin-right: 4px;"></i>
                                    Freshman
                                </span>
                            @else
                                <span style="color: var(--info);">
                                    <i class="fas fa-user-check" style="margin-right: 4px;"></i>
                                    Continuing Student
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium" style="color: var(--text-muted-light);">Year Level</label>
                        <p class="font-semibold" x-text="getYearLevelText(yearLevel)"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-graduation-cap" style="margin-right: 8px; color: var(--primary);"></i>
                    Program Selection
                </h3>
            </div>
            <div class="card-body">
                @if($isFreshman)
                    <div>
                        <label for="program_id" class="block text-sm font-medium mb-2">Select Program</label>
                        <select name="program_id" 
                                id="program_id" 
                                class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                x-model="selectedProgram"
                                @change="onProgramChange()"
                                required>
                            <option value="">Choose a program...</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}">{{ $prog->program_name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div>
                        <label class="block text-sm font-medium mb-2">Current Program</label>
                        <div class="w-full input-padding border border-gray-300 rounded-lg" 
                             style="background-color: var(--light-bg); color: var(--text-muted-light);">
                            {{ $program->program_name }}
                        </div>
                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                        <p class="text-xs mt-1" style="color: var(--text-muted-light);">
                            Program is based on your previous enrollment and cannot be changed.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users" style="margin-right: 8px; color: var(--primary);"></i>
                    Section Selection
                </h3>
            </div>
            <div class="card-body">
                <div>
                    <label for="section_id" class="block text-sm font-medium mb-2">Select Section</label>
                    <select name="section_id" 
                            id="section_id" 
                            class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            x-model="selectedSection"
                            required>
                        <option value="">Choose a section...</option>
                        <template x-for="section in sections" :key="section.id">
                            <option :value="section.id" x-text="section.section_name"></option>
                        </template>
                    </select>
                    <p class="text-xs mt-1" style="color: var(--text-muted-light);">
                        Available sections for your program will be loaded automatically.
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-book" style="margin-right: 8px; color: var(--primary);"></i>
                    Course Selection
                </h3>
            </div>
            <div class="card-body">
                <div x-show="availableCourses.length === 0" class="empty-state">
                    <i class="fas fa-info-circle empty-icon"></i>
                    <p>Please select a program first to see available courses.</p>
                </div>

                <div x-show="availableCourses.length > 0" class="space-y-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-semibold">Available Courses</h4>
                        <div class="text-sm" style="color: var(--text-muted-light);">
                            Total Selected: <span x-text="selectedCourses.length" class="font-semibold"></span>
                        </div>
                    </div>

                    <template x-for="course in availableCourses" :key="course.course_code">
                        <div class="course-item" 
                             :class="{ 'ge-course': course.is_general_education }"
                             style="position: relative;">
                            <div class="flex items-start">
                                <input type="checkbox" 
                                       :value="course.course_code"
                                       :name="'course_codes[]'"
                                       :id="'course_' + course.course_code"
                                       @change="toggleCourse(course.course_code)"
                                       class="mt-1 mr-3">
                                
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="course-code" x-text="course.course_code"></span>
                                            <span x-show="course.is_general_education" class="ge-badge">GE</span>
                                        </div>
                                        <span class="text-sm font-medium" style="color: var(--text-muted-light);" 
                                              x-text="course.credits + ' units'"></span>
                                    </div>
                                    <h4 class="course-title" x-text="course.course_title"></h4>
                                    <p class="course-details" x-text="course.course_description"></p>
                                    
                                    <!-- Schedule Selection -->
                                    <div x-show="selectedCourses.includes(course.course_code)" 
                                         class="mt-3 p-3 rounded-lg" 
                                         style="background-color: var(--light-bg); border: 1px solid var(--border-light);">
                                        <label class="block text-sm font-medium mb-2">Select Schedule:</label>
                                        <select :name="'schedule_ids[' + course.course_code + ']'"
                                                class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                @change="loadSchedules(course.course_code)">
                                            <option value="">Loading schedules...</option>
                                        </select>
                                        <div class="schedule-loading hidden">
                                            <p class="text-xs mt-1" style="color: var(--text-muted-light);">
                                                <i class="fas fa-spinner fa-spin mr-1"></i>
                                                Loading available schedules...
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clipboard-check" style="margin-right: 8px; color: var(--primary);"></i>
                    Enrollment Summary
                </h3>
            </div>
            <div class="card-body">
                <div x-show="selectedCourses.length === 0" class="empty-state">
                    <i class="fas fa-clipboard-list empty-icon"></i>
                    <p>No courses selected yet. Please select courses to see your enrollment summary.</p>
                </div>

                <div x-show="selectedCourses.length > 0">
                    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div class="stat-card">
                            <div class="stat-value" x-text="selectedCourses.length"></div>
                            <div class="stat-label">Courses</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" x-text="getTotalUnits()"></div>
                            <div class="stat-label">Total Units</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" x-text="getYearLevelText(yearLevel)"></div>
                            <div class="stat-label">Year Level</div>
                        </div>
                    </div>

                    <div class="border-t pt-4" style="border-color: var(--border-light);">
                        <h5 class="font-semibold mb-3">Selected Courses:</h5>
                        <div class="space-y-2">
                            <template x-for="courseCode in selectedCourses" :key="courseCode">
                                <div class="flex items-center justify-between p-2 rounded" 
                                     style="background-color: var(--light-bg);">
                                    <span x-text="getCourseTitle(courseCode)" class="font-medium"></span>
                                    <span x-text="getCourseUnits(courseCode) + ' units'" 
                                          class="text-sm" style="color: var(--text-muted-light);"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('studentSide.enrollment.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Enrollments
            </a>
            
            <button type="submit" 
                    class="btn-primary"
                    :disabled="selectedCourses.length === 0"
                    :class="{ 'opacity-50 cursor-not-allowed': selectedCourses.length === 0 }">
                <i class="fas fa-save mr-2"></i>
                Complete Enrollment
            </button>
        </div>
    </form>

    <script>
        function enrollmentForm() {
            return {
                selectedProgram: @if(!$isFreshman) '{{ $program->id }}' @else '' @endif,
                selectedSection: '',
                selectedCourses: [],
                availableCourses: [],
                sections: @if(!$isFreshman) @json($sections) @else [] @endif,
                yearLevel: {{ $yearLevel }},
                scheduleCache: {},

                init() {
                    @if(!$isFreshman)
                        this.loadCourses();
                    @endif
                },

                async onProgramChange() {
                    if (!this.selectedProgram) {
                        this.sections = [];
                        this.availableCourses = [];
                        this.selectedCourses = [];
                        return;
                    }

                    await this.loadSections();
                    await this.loadCourses();
                },

                async loadSections() {
                    try {
                        const response = await fetch(`{{ route('studentSide.enrollment.sections') }}?program_id=${this.selectedProgram}`);
                        this.sections = await response.json();
                    } catch (error) {
                        console.error('Error loading sections:', error);
                        this.sections = [];
                    }
                },

                async loadCourses() {
                    if (!this.selectedProgram) return;

                    try {
                        const response = await fetch(`{{ route('studentSide.enrollment.courses') }}?program_id=${this.selectedProgram}&year_level=${this.yearLevel}`);
                        const courses = await response.json();
                        
                        this.availableCourses = courses.map(course => ({
                            ...course,
                            is_general_education: course.program && course.program.program_name === 'General Education'
                        }));
                        
                        // Clear selected courses when changing program
                        this.selectedCourses = [];
                    } catch (error) {
                        console.error('Error loading courses:', error);
                        this.availableCourses = [];
                    }
                },

                async toggleCourse(courseCode) {
                    const index = this.selectedCourses.indexOf(courseCode);
                    
                    if (index > -1) {
                        this.selectedCourses.splice(index, 1);
                    } else {
                        this.selectedCourses.push(courseCode);
                        await this.loadSchedules(courseCode);
                    }
                },

                async loadSchedules(courseCode) {
                    if (this.scheduleCache[courseCode]) return;

                    try {
                        const response = await fetch(`{{ route('studentSide.enrollment.schedules') }}?course_code=${courseCode}&section_id=${this.selectedSection}`);
                        const schedules = await response.json();
                        
                        this.scheduleCache[courseCode] = schedules;
                        
                        // Update the select options
                        const selectElement = document.querySelector(`select[name="schedule_ids[${courseCode}]"]`);
                        if (selectElement) {
                            selectElement.innerHTML = schedules.length === 0 
                                ? '<option value="">No schedules available</option>'
                                : '<option value="">Choose schedule...</option>' + 
                                  schedules.map(schedule => 
                                    `<option value="${schedule.id}">
                                        ${schedule.day} ${schedule.starting_time} - ${schedule.ending_time}
                                        ${schedule.room ? `(${schedule.room.roomname})` : ''}
                                        ${schedule.instructor ? `- ${schedule.instructor.first_name} ${schedule.instructor.last_name}` : ''}
                                    </option>`
                                  ).join('');
                        }
                    } catch (error) {
                        console.error('Error loading schedules:', error);
                    }
                },

                getTotalUnits() {
                    return this.selectedCourses.reduce((total, courseCode) => {
                        const course = this.availableCourses.find(c => c.course_code === courseCode);
                        return total + (course ? parseInt(course.credits) : 0);
                    }, 0);
                },

                getCourseTitle(courseCode) {
                    const course = this.availableCourses.find(c => c.course_code === courseCode);
                    return course ? `${course.course_code} - ${course.course_name}` : courseCode;
                },

                getCourseUnits(courseCode) {
                    const course = this.availableCourses.find(c => c.course_code === courseCode);
                    return course ? course.credits : 0;
                },

                getYearLevelText(level) {
                    const levels = {
                        1: '1st Year',
                        2: '2nd Year',
                        3: '3rd Year',
                        4: '4th Year',
                        5: '5th Year'
                    };
                    return levels[level] || level + 'th Year';
                }
            }
        }
    </script>

    <style>
        .course-item input[type="checkbox"]:checked + .flex-1 {
            opacity: 0.9;
        }
        
        .schedule-loading {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .dark .course-item {
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .dark .ge-course {
            background-color: rgba(16, 185, 129, 0.1);
        }
        
        select:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</x-studentapp-layout>