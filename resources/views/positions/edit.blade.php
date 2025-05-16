<x-app-layout>
    <x-slot name="title">
        Edit Position
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Edit Position</div>
        <div class="dashboard-subtitle">Update position information</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex mb-6">
            <a href="{{ route('positions.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Positions
            </a>
        </div>

        <div class="module-card">
            <form action="{{ route('positions.update', $position->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="position_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Position Name</label>
                    <input type="text" name="position_name" id="position_name" value="{{ old('position_name', $position->position_name) }}" 
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('position_name') border-red-500 @enderror" 
                           required>
                    @error('position_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        Update Position
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>