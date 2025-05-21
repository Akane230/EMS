<x-studentapp-layout>
    <x-slot name="title">New Enrollment</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Enroll in Courses</h2>
                
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                    <p class="text-blue-600 dark:text-blue-200">
                        <strong>Current Term:</strong> {{ $currentTerm->name }} ({{ $currentTerm->start_date->format('M Y') }} - {{ $currentTerm->end_date->format('M Y') }})
                    </p>
                    <p class="text-blue-600 dark:text-blue-200 mt-1">
                        <strong>Program:</strong> {{ $program->name }}
                    </p>
                </div>

                <form action="{{ route('studentSide.enrollment.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Section</label>
                        <select id="section_id" name="section_id" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Select Section --</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available Courses</label>
                        
                        @if($courses->isEmpty())
                            <div class="bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-200 p-4 rounded-lg">
                                No courses available for your program.
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($courses as $course)
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="course-{{ $course->id }}" name="course_ids[]" type="checkbox" value="{{ $course->id }}" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                        </div>
                                        <label for="course-{{ $course->id }}" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            <span class="font-medium">{{ $course->code }} - {{ $course->name }}</span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $course->description }}</p>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('studentSide.enrollment.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Enrollment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-studentapp-layout>