<x-app-layout>
    <x-slot name="title">
        Department Details
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Department Details</div>
        <div class="dashboard-subtitle">Viewing details of {{ $department->department_name }}</div>
    </div>

    <div class="module-card">
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-4">Department Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Department Name</p>
                    <p class="font-medium">{{ $department->department_name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Created At</p>
                    <p class="font-medium">{{ $department->created_at->format('F d, Y') }}</p>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Description</p>
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p>{{ $department->description }}</p>
                </div>
            </div>

            <div class="mt-8 flex items-center space-x-4">
                <a href="{{ route('departments.edit', $department) }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition">
                    Edit Department <i class="fas fa-edit ml-2"></i>
                </a>

                <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition" onclick="return confirm('Are you sure you want to delete this department?')">
                        Delete Department <i class="fas fa-trash ml-2"></i>
                    </button>
                </form>

                <a href="{{ route('departments.index') }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</x-app-layout>