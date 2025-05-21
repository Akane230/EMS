<x-app-layout>
    <x-slot name="title">
        Section Details
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Section Details</div>
        <div class="dashboard-subtitle">View section information</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('sections.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Sections
            </a>
            <div class="flex space-x-2">
                <a href="{{ route('sections.edit', $section) }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form action="{{ route('sections.destroy', $section) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this section?')" class="px-4 py-2 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition"
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="module-card">
            <div class="overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 border-b border-gray-200 dark:border-gray-600 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium">Section Information</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $section->id }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Section Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $section->section_name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Program</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $section->program->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $section->created_at->format('F d, Y h:i A') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $section->updated_at->format('F d, Y h:i A') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Section Students could be added here if there's a relationship -->
        
        <!-- Section Subjects could be added here if there's a relationship -->
    </div>
</x-app-layout>