<x-app-layout>
    <x-slot name="title">
        Create New Program
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Create New Program</div>
        <div class="dashboard-subtitle">Add a new academic program to the system</div>
    </div>
    
    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <form action="{{ route('programs.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="program_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Program Name</label>
                    <input type="text" id="program_name" name="program_name" class="w-full pl-4 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Enter program name" value="{{ old('program_name') }}" required>
                    @error('program_name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="department_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                    <select id="department_id" name="department_id" class="w-full pl-4 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="program_description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Program Description</label>
                    <textarea id="program_description" name="program_description" rows="4" class="w-full pl-4 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Enter program description" required>{{ old('program_description') }}</textarea>
                    @error('program_description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <a href="{{ route('programs.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        Create Program
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>