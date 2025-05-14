<x-app-layout>
    <x-slot name="title">
        Edit Department
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Edit Department</div>
        <div class="dashboard-subtitle">Update information for {{ $department->deparment_name }}</div>
    </div>

    <div class="module-card">
        <form action="{{ route('departments.update', $department) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="deparment_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Department Name</label>
                <input type="text" id="deparment_name" name="deparment_name" value="{{ old('deparment_name', $department->deparment_name) }}" 
                    class="border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700"
                    placeholder="Enter department name" required maxlength="100">
                @error('deparment_name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Description</label>
                <textarea id="description" name="description" rows="4" 
                    class="border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700"
                    placeholder="Enter department description" required>{{ old('description', $department->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center space-x-4">
                <button type="submit" class="module-action">
                    Update Department <i class="fas fa-save ml-2"></i>
                </button>
                <a href="{{ route('departments.show', $department) }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>