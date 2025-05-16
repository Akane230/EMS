<x-app-layout>
    <x-slot name="title">
        Enrollment Details
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Enrollment Details</div>
        <div class="dashboard-subtitle">View detailed information about this enrollment</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center space-x-4 add-export-container">
            <a href="{{ route('enrollments.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
            <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="module-action">
                <i class="fas fa-edit mr-2"></i> Edit Enrollment
            </a>
        </div>

        <div class="module-card">
            @if(session('success'))
            <div class="mb-4 px-4 py-2 border-l-4 border-green-500 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Student Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Student ID:</span>
                            <span class="font-medium ml-2">{{ $enrollment->student->id ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Name:</span>
                            <span class="font-medium ml-2">{{ $enrollment->student->last_name ?? 'N/A' }}, {{ $enrollment->student->first_name ?? '' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Email:</span>
                            <span class="font-medium ml-2">{{ $enrollment->student->email ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Year Level:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                Year {{ $enrollment->year_level }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Course Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Course Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Course Code:</span>
                            <span class="font-medium ml-2">{{ $enrollment->course_code }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Course Name:</span>
                            <span class="font-medium ml-2">{{ $enrollment->course->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Term:</span>
                            <span class="font-medium ml-2">{{ $enrollment->term->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Section:</span>
                            <span class="font-medium ml-2">{{ $enrollment->section->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Schedule Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Schedule Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Days:</span>
                            <span class="font-medium ml-2">{{ $enrollment->schedule->day ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Time:</span>
                            <span class="font-medium ml-2">
                                @if($enrollment->schedule)
                                    {{ \Carbon\Carbon::parse($enrollment->schedule->starting_time ?? '')->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($enrollment->schedule->ending_time ?? '')->format('h:i A') }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Room:</span>
                            <span class="font-medium ml-2">{{ $enrollment->schedule->room ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Enrollment Details -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Enrollment Details</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Enrollment ID:</span>
                            <span class="font-medium ml-2">{{ $enrollment->id }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Created At:</span>
                            <span class="font-medium ml-2">{{ $enrollment->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Last Updated:</span>
                            <span class="font-medium ml-2">{{ $enrollment->updated_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('enrollments.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Back to List
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition" onclick="return confirm('Are you sure you want to delete this enrollment?')">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Remove success message after 3 seconds
            const successMessage = document.querySelector('[class*="border-green-500"]');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.remove();
                }, 3000);
            }
        });
    </script>
</x-app-layout>