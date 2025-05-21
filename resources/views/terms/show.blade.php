<x-app-layout>
    <x-slot name="title">
        View Term
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">View Term</div>
        <div class="dashboard-subtitle">Detailed information about this academic term</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('terms.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Terms
            </a>
            <div class="flex space-x-2">
                <a href="{{ route('terms.edit', $term->id) }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition">
                </a>
                <form action="{{ route('terms.destroy', $term->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition" onclick="return confirm('Are you sure you want to delete this term?')">
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="module-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">School Year/Semester</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $term->schoolyear_semester }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2">Status</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $term->status }}</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-2">Created At</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $term->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2">Start Date</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($term->start_date)->format('M d, Y') }}</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-2">Last Updated</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $term->updated_at->format('M d, Y h:i A') }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2">End Date</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($term->end_date)->format('M d, Y') }}</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-2">Duration</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ \Carbon\Carbon::parse($term->start_date)->diffInDays(\Carbon\Carbon::parse($term->end_date)) + 1 }} days
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>