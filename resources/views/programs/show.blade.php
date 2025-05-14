<x-app-layout>
    <x-slot name="title">
        {{ $program->program_name }}
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">{{ $program->program_name }}</div>
        <div class="dashboard-subtitle">Program Details</div>
    </div>
    
    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Program Information</h2>
                <div class="border-t border-gray-200 dark:border-gray-600"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Program Name</p>
                    <p class="font-medium">{{ $program->program_name }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Department</p>
                    <p class="font-medium">{{ $program->department->name ?? 'N/A' }}</p>
                </div>
                
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                    <p class="font-medium">{{ $program->program_description }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Created On</p>
                    <p class="font-medium">{{ $program->created_at->format('M d, Y') }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                    <p class="font-medium">{{ $program->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
            
            <div class="mt-6 border-t border-gray-200 dark:border-gray-600 pt-6 flex justify-between">
                <div>
                    <a href="{{ route('programs.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-200">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Programs
                    </a>
                </div>
                
                <div class="flex space-x-4">
                    <a href="{{ route('programs.edit', $program->id) }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    
                    <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition" onclick="return confirm('Are you sure you want to delete this program?')">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>