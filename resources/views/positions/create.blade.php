<x-app-layout>
    <x-slot name="title">
        Create Position
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Create Position</div>
        <div class="dashboard-subtitle">Add a new position to the system</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex mb-6">
            <a href="{{ route('positions.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Positions
            </a>
        </div>

        <div class="module-card">
            <form action="{{ route('positions.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="position_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Position Name</label>
                    <input type="text" name="position_name" id="position_name" value="{{ old('position_name') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('position_name') border-red-500 @enderror input-padding"
                        required>
                    @error('position_name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="department_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                    <select id="department_id" name="department_id" class="w-full pl-4 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('department_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="module-action">
                        Create Position <i class="fas fa-save ml-2"></i>
                    </button>
                    <a href="{{ route('positions.index') }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>