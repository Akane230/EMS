<x-app-layout>
    <x-slot name="title">
        Assign Position to Instructor
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Assign Position to Instructor</div>
        <div class="dashboard-subtitle">Create a new position assignment</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <a href="{{ route('instructor-positions.index') }}" class="flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>

            @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Please fix the following errors:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('instructor-positions.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="instructor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instructor</label>
                        <select id="instructor_id" name="instructor_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-primary-500 focus:border-primary-500 rounded-md">
                            <option value="">-- Select Instructor --</option>
                            @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->first_name }} {{ $instructor->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                        <select id="position_id" name="position_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-primary-500 focus:border-primary-500 rounded-md">
                            <option value="">-- Select Position --</option>
                            @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->position_name }} {{ $position->department->department_name ?? 'N/A'}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="module-action">
                        Assign Position <i class="fas fa-save ml-2"></i>
                    </button>
                    <a href="{{ route('instructor-positions.index') }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>