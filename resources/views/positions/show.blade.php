<x-app-layout>
    <x-slot name="title">
        Position Details
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Position Details</div>
        <div class="dashboard-subtitle">View detailed information about this position</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex mb-6 space-x-2">
            <a href="{{ route('positions.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Positions
            </a>
            <a href="{{ route('positions.edit', $position->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition" onclick="return confirm('Are you sure you want to delete this position?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>

        <div class="module-card">
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Position Information</h3>
                
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">ID</p>
                            <p class="font-medium">{{ $position->id }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Position Name</p>
                            <p class="font-medium">{{ $position->position_name }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created At</p>
                            <p class="font-medium">{{ $position->created_at->format('F j, Y g:i A') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                            <p class="font-medium">{{ $position->updated_at->format('F j, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>