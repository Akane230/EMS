<x-studentapp-layout>
    <x-slot name="title">Student Dashboard</x-slot>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
    @endif
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-md p-6 mb-6 text-white">
                <h1 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="opacity-90">Here's what's happening with your academics today</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Current Term Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-200 mr-4">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Current Term</h3>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $currentTerm->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Enrolled Courses Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-200 mr-4">
                            <i class="fas fa-book fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Enrolled Courses</h3>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $enrolledCourses }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Credits Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-200 mr-4">
                            <i class="fas fa-star fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Total Credits</h3>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $totalCredits }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Classes Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Today's Classes</h3>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @if($todayClasses->isEmpty())
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-calendar-check fa-2x mb-2"></i>
                        <p>No classes scheduled for today</p>
                    </div>
                    @else
                    @foreach($todayClasses as $class)
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-md p-3 text-blue-600 dark:text-blue-200">
                                <i class="fas fa-chalkboard-teacher fa-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $class->course->name }}
                                    </h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        {{ $class->section->name }}
                                    </span>
                                </div>
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    <p>
                                        <i class="far fa-clock mr-1"></i>
                                        {{ \Carbon\Carbon::parse($class->schedule->start_time)->format('g:i A') }} -
                                        {{ \Carbon\Carbon::parse($class->schedule->end_time)->format('g:i A') }}
                                    </p>
                                    <p class="mt-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $class->schedule->room->name ?? 'Room TBD' }} |
                                        {{ $class->schedule->instructor->name ?? 'Instructor TBD' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Enrollment Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Enrollment</h3>
                    </div>
                    <div class="p-6">
                        @if($isEnrolled)
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900">
                                <i class="fas fa-check text-green-600 dark:text-green-200"></i>
                            </div>
                            <h4 class="mt-3 text-lg font-medium text-gray-900 dark:text-white">Enrollment Complete</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                You're enrolled in {{ $enrolledCourses }} courses for {{ $currentTerm->name }}.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('studentSide.enrollment.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    View Enrollments
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900">
                                <i class="fas fa-exclamation text-yellow-600 dark:text-yellow-200"></i>
                            </div>
                            <h4 class="mt-3 text-lg font-medium text-gray-900 dark:text-white">Enrollment Required</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                You haven't enrolled for {{ $currentTerm->name }} yet.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('studentSide.enrollment.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Enroll Now
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Documents Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Documents</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900">
                                <i class="fas fa-file-alt text-blue-600 dark:text-blue-200"></i>
                            </div>
                            <h4 class="mt-3 text-lg font-medium text-gray-900 dark:text-white">Certificate of Registration</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Download your official enrollment document.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('studentSide.enrollment.download.cor') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-download mr-2"></i> Download COR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-studentapp-layout>