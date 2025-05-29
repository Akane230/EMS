<x-app-layout>
    <x-slot name="title">
        Add Room
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Add New Room</div>
        <div class="dashboard-subtitle">Create a new room in the system</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <a href="{{ route('rooms.index') }}" class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Rooms
                </a>
            </div>

            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="roomname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Room Name</label>
                    <input type="text" name="roomname" id="roomname" value="{{ old('roomname') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Enter room name" required>
                    @error('roomname')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                    <select name="department_id" id="department_id"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('department_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="module-action">
                        Create Room <i class="fas fa-save ml-2"></i>
                    </button>
                    <a href="{{ route('rooms.index') }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>