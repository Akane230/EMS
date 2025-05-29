<x-app-layout title="Add New Course">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl">Add New Course</h2>
            <a href="{{ route('courses.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Back
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
            <p class="font-bold">Error!</p>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="module-card">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Course Code</label>
                    <input type="text" name="course_code" value="{{ old('course_code') }}"
                        class="input-padding w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Course Name</label>
                    <input type="text" name="course_name" value="{{ old('course_name') }}"
                        class="input-padding w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Credits</label>
                    <input type="number" name="credits" value="{{ old('credits') }}"
                        class="input-padding w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required min="1">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="3"
                        class="input-padding w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('description') }}</textarea>
                </div>

                <div class="mb-6">
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

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Program</label>
                    <select name="program_id"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select Program</option>
                        @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->program_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="module-action">
                        Create Course <i class="fas fa-save ml-2"></i>
                    </button>
                    <a href="{{ route('courses.index') }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>