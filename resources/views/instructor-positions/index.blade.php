<x-app-layout>
    <x-slot name="title">
        Instructor Position Management
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Instructor Position Management</div>
        <div class="dashboard-subtitle">Manage all instructor positions in the system</div>
    </div>

    <div class="flex items-center space-x-4 add-export-container">
        <a href="{{ route('instructor-positions.create') }}" class="module-action">
            Assign Position <i class="fas fa-plus ml-2"></i>
        </a>
        <a href="{{ route('instructor-positions.export.pdf') }}" class="px-4 py-2 bg-green-600 text-black rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
            <i class="fas fa-file-pdf mr-2"></i> Export PDF
        </a>
    </div>
    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <form action="{{ route('instructor-positions.index') }}" method="GET">
                    <div class="flex">
                        <div class="relative flex-grow">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Search instructor positions...">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button type="submit" class="ml-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                            Search
                        </button>
                        <a href="{{ route('instructor-positions.index') }}" class="ml-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Instructor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Assigned Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($instructorPositions as $instructorPosition)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $instructorPosition->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $instructorPosition->instructor->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $instructorPosition->instructor->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $instructorPosition->position->title ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $instructorPosition->position->department ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $instructorPosition->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('instructor-positions.show', $instructorPosition->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('instructor-positions.edit', $instructorPosition->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('instructor-positions.destroy', $instructorPosition->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200" onclick="return confirm('Are you sure you want to delete this assignment?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No instructor positions found{{ request('search') ? ' matching "' . request('search') . '"' : '' }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                @if($instructorPositions->hasPages())
                <div class="pagination-wrapper">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between flex-wrap sm:hidden">
                            {{-- Mobile pagination controls --}}
                            @if($instructorPositions->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                Previous
                            </span>
                            @else
                            <a href="{{ $instructorPositions->appends(request()->except('page'))->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Previous
                            </a>
                            @endif

                            @if($instructorPositions->hasMorePages())
                            <a href="{{ $instructorPositions->appends(request()->except('page'))->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Next
                            </a>
                            @else
                            <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                Next
                            </span>
                            @endif
                        </div>

                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            {{-- Results info --}}
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    Showing
                                    <span class="font-medium">{{ $instructorPositions->firstItem() ?? 0 }}</span>
                                    to
                                    <span class="font-medium">{{ $instructorPositions->lastItem() ?? 0 }}</span>
                                    of
                                    <span class="font-medium">{{ $instructorPositions->total() }}</span>
                                    results
                                    @if(request('search'))
                                    for "<span class="font-medium">{{ request('search') }}</span>"
                                    @endif
                                </p>
                            </div>

                            {{-- Desktop pagination links --}}
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    {{-- Previous Page Link --}}
                                    @if($instructorPositions->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left w-5 h-5"></i>
                                    </span>
                                    @else
                                    <a href="{{ $instructorPositions->appends(request()->except('page'))->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left w-5 h-5"></i>
                                    </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach($instructorPositions->appends(request()->except('page'))->getUrlRange(1, $instructorPositions->lastPage()) as $page => $url)
                                    @if($page == $instructorPositions->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary-50 dark:bg-primary-900 text-sm font-medium text-primary-600 dark:text-primary-300">
                                        {{ $page }}
                                    </span>
                                    @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        {{ $page }}
                                    </a>
                                    @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if($instructorPositions->hasMorePages())
                                    <a href="{{ $instructorPositions->appends(request()->except('page'))->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right w-5 h-5"></i>
                                    </a>
                                    @else
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right w-5 h-5"></i>
                                    </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>