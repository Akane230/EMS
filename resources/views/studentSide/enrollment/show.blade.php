@props(['title' => 'Enrollment Details'])

<x-studentapp-layout :title="$title">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Enrollment Details</h1>
            <a href="{{ route('student.enrollment.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i> Back to Enrollments
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                    {{ $enrollment->course->course_code }} - {{ $enrollment->course->course_name }}
                </h2>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Course Information</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Course Code</p>
                                <p class="text-gray-900 dark:text-white">{{ $enrollment->course->course_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Course Name</p>
                                <p class="text-gray-900 dark:text-white">{{ $enrollment->course->course_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Credits</p>
                                <p class="text-gray-900 dark:text-white">{{ $enrollment->course->credits }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Program</p>
                                <p class="text-gray-900 dark:text-white">{{ $enrollment->course->program->program_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                                <p class="text-gray-900 dark:text-white">{{ $enrollment->course->description ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Enrollment Details</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Term</p>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $enrollment->term->schoolyear_semester }} ({{ $enrollment->term->start_date->format('M d, Y') }} - {{ $enrollment->term->end_date->format('M d, Y') }})
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Year Level</p>
                                <p class="text-gray-900 dark:text-white">
                                    Year {{ $enrollment->year_level }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Section</p>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $enrollment->section->section_name ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Schedule</p>
                                @if($enrollment->schedule)
                                <p class="text-gray-900 dark:text-white">
                                    {{ $enrollment->schedule->day }}: {{ $enrollment->schedule->formatted_start_time }} - {{ $enrollment->schedule->formatted_end_time }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Room: {{ $enrollment->schedule->room->roomname ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Instructor:
                                    @if($enrollment->schedule->instructor)
                                    {{ $enrollment->schedule->instructor->last_name }}, {{ $enrollment->schedule->instructor->first_name }}
                                    @else
                                    Not assigned
                                    @endif
                                </p>
                                @else
                                <p class="text-gray-900 dark:text-white">No schedule assigned</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Enrollment Date</p>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $enrollment->created_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-between">
                <form action="{{ route('student.enrollment.destroy', $enrollment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to drop this course?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-trash-alt mr-2"></i> Drop Course
                    </button>
                </form>
                <a href="{{ route('student.enrollment.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</x-studentapp-layout>