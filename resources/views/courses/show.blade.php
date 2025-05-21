<x-app-layout title="Course Details">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl">Course Details</h2>
            <a href="{{ route('courses.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Back to Courses
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="module-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-medium mb-2">Course Information</h3>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Code:</span> {{ $course->course_code }}</p>
                        <p><span class="font-semibold">Name:</span> {{ $course->course_name }}</p>
                        <p><span class="font-semibold">Credits:</span> {{ $course->credits }}</p>
                        <p><span class="font-semibold">Credits:</span> {{ $course->year_level }}</p>
                        <p><span class="font-semibold">Program:</span> {{ $course->program->program_name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium mb-2">Description</h3>
                    <p class="text-gray-700 dark:text-gray-300">{{ $course->description ?? 'No description available' }}</p>
                </div>
            </div>

            <div class="flex space-x-4 mt-8">
                <a href="{{ route('courses.edit', $course->course_code) }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition">
                    Edit Course <i class="fas fa-edit ml-2"></i>
                </a>
                <form action="{{ route('courses.destroy', $course->course_code) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition" onclick="return confirm('Are you sure you want to delete this course?')">
                        Delete Course <i class="fas fa-trash ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>