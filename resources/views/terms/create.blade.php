<x-app-layout>
    <x-slot name="title">
        Create Term
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Create Term</div>
        <div class="dashboard-subtitle">Add a new academic term to the system</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('terms.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Terms
            </a>
        </div>

        <div class="module-card">
            <form action="{{ route('terms.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="schoolyear_semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">School Year/Semester <span class="text-red-600">*</span></label>
                    <input type="text" name="schoolyear_semester" id="schoolyear_semester" value="{{ old('schoolyear_semester') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        placeholder="e.g. 2025-2026 First Semester" required>
                    @error('schoolyear_semester')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status <span class="text-red-600">*</span></label>
                    <select name="status" id="status" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding" required>
                        <option value="active">Active</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="completed">Completed</option>
                    </select>
                    @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date <span class="text-red-600">*</span></label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        required>
                    @error('start_date')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date <span class="text-red-600">*</span></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        required>
                    @error('end_date')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="module-action">
                        Create Term <i class="fas fa-save ml-2"></i>
                    </button>
                    <a href="{{ route('terms.index') }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>