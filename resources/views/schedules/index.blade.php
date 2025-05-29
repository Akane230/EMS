<x-app-layout>
    <x-slot name="title">
        Schedule Management
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Schedule Management</div>
        <div class="dashboard-subtitle">Manage all class schedules in the system</div>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-6 border-l-4 border-green-500 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex items-center space-x-4 add-export-container">
        <a href="{{ route('schedules.create') }}" class="module-action">
            Add Schedule <i class="fas fa-plus ml-2"></i>
        </a>
        <a href="{{ route('schedules.export.pdf') }}" class="px-4 py-2 bg-green-600 text-black rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
            <i class="fas fa-file-pdf mr-2"></i> Export PDF
        </a>
    </div>
    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <form action="{{ route('schedules.index') }}" method="GET">
                    <div class="flex flex-wrap gap-2">
                        <div class="relative flex-grow">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Search schedules...">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        
                        <div class="min-w-[150px]">
                            <select name="day" class="w-full py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">All Days</option>
                                <option value="Sunday" {{ request('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                <option value="Monday" {{ request('day') == 'Monday' ? 'selected' : '' }}>Monday</option>
                                <option value="Tuesday" {{ request('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                <option value="Wednesday" {{ request('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                <option value="Thursday" {{ request('day') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                <option value="Friday" {{ request('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                                <option value="Saturday" {{ request('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                            Filter
                        </button>
                        
                        <a href="{{ route('schedules.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Section</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Instructor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($schedules as $schedule)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">
                                @php
                                $dayColorClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                
                                switch ($schedule->day) {
                                    case 'Monday':
                                        $dayColorClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                        break;
                                    case 'Tuesday':
                                        $dayColorClass = 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200';
                                        break;
                                    case 'Wednesday':
                                        $dayColorClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                        break;
                                    case 'Thursday':
                                        $dayColorClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                        break;
                                    case 'Friday':
                                        $dayColorClass = 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                        break;
                                    case 'Saturday':
                                        $dayColorClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200';
                                        break;
                                    case 'Sunday':
                                        $dayColorClass = 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200';
                                        break;
                                }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $dayColorClass }}">
                                    {{ $schedule->day }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($schedule->starting_time)->format('h:i A') }} - 
                                {{ \Carbon\Carbon::parse($schedule->ending_time)->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $schedule->course_code }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $schedule->course->course_name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $schedule->section->section_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $schedule->instructor->first_name ?? 'N/A' }} {{ $schedule->instructor->last_name ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $schedule->room->roomname ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('schedules.export.individual.pdf', $schedule->id) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200" title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('schedules.show', $schedule->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 delete-button" onclick="return confirm('Are you sure you want to delete this schedule?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No schedules found {{ request('search') ? ' matching "' . request('search') . '"' : '' }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $schedules->appends(request()->except('page'))->links() }}
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