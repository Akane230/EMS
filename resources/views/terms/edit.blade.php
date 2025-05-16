<x-app-layout>
    <x-slot name="title">
        Edit Term
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Edit Term</div>
        <div class="dashboard-subtitle">Update information for this academic term</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('terms.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Terms
            </a>
        </div>

        <div class="module-card">
            <form action="{{ route('terms.update', $term->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="schoolyear_semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">School Year/Semester <span class="text-red-600">*</span></label>
                    <input type="text" name="schoolyear_semester" id="schoolyear_semester" value="{{ old('schoolyear_semester', $term->schoolyear_semester) }}" 
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="e.g. 2025-2026 First Semester" required>
                    @error('schoolyear_semester')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date <span class="text-red-600">*</span></label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $term->start_date) }}" 
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        required>
                    @error('start_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date <span class="text-red-600">*</span></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $term->end_date) }}" 
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        required>
                    @error('end_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        Update Term <i class="fas fa-save ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>