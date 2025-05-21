<x-app-layout>
    <x-slot name="title">
        Enrollment Management
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Enrollment Management</div>
        <div class="dashboard-subtitle">Manage all student course enrollments in the system</div>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-6 border-l-4 border-green-500 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex items-center space-x-4 add-export-container">
        <a href="{{ route('enrollments.create') }}" class="module-action">
            Add Enrollment <i class="fas fa-plus ml-2"></i>
        </a>
        <a href="{{ route('enrollments.export.pdf') }}" class="px-4 py-2 bg-green-600 text-black rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
            <i class="fas fa-file-pdf mr-2"></i> Export PDF
        </a>
    </div>
    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <form action="{{ route('enrollments.index') }}" method="GET">
                    <div class="flex flex-wrap gap-2">
                        <div class="relative flex-grow">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Search by student name or course...">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        
                        <div class="min-w-[150px]">
                            <select name="term_id" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">All Terms</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}" {{ request('term_id') == $term->id ? 'selected' : '' }}>
                                        {{ $term->schoolyear_semester }} 
                                        <span class="text-sm text-gray-500">
                                            ({{ ucfirst($term->status) }})
                                        </span>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="min-w-[150px]">
                            <select name="year_level" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">All Year Levels</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ request('year_level') == $i ? 'selected' : '' }}>
                                        Year {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                            Filter
                        </button>
                        
                        <a href="{{ route('enrollments.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Program</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Term</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Section</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Schedule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Year Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $enrollment->student->last_name ?? 'N/A' }}, {{ $enrollment->student->first_name ?? '' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $enrollment->student->id ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $enrollment->course->program->program_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $enrollment->term->schoolyear_semester ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $enrollment->course_code }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $enrollment->course->course_name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $enrollment->section->section_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($enrollment->schedule)
                                    {{ $enrollment->schedule->day ?? 'N/A' }}, 
                                    {{ \Carbon\Carbon::parse($enrollment->schedule->starting_time ?? '')->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($enrollment->schedule->ending_time ?? '')->format('h:i A') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    Year {{ $enrollment->year_level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('enrollments.show', $enrollment->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 delete-button" onclick="return confirm('Are you sure you want to delete this enrollment?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No enrollments found {{ request('search') ? ' matching "' . request('search') . '"' : '' }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $enrollments->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Remove success message after 3 seconds
            const successMessage = document.querySelector('[class*="border-green-500"]');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.remove();
                }, 3000);
            }
        });
    </script>
</x-app-layout>