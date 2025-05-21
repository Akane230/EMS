<x-app-layout>
    <x-slot name="title">
        Schedule Details
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Schedule Details</div>
        <div class="dashboard-subtitle">View complete information about this schedule</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <div class="flex flex-wrap justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">
                        <span class="me-2">{{ $schedule->course->course_name ?? 'N/A' }}</span>
                        <span class="px-2 py-1 text-xs rounded-full 
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
                        {{ $dayColorClass }}">
                            {{ $schedule->day }}
                        </span>
                    </h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition" onclick="return confirm('Are you sure you want to delete this schedule?')">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-semibold mb-2">Course Information</h3>
                        <div class="grid grid-cols-1 gap-2">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Course Code:</span>
                                <span class="font-medium">{{ $schedule->course_code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Course Name:</span>
                                <span class="font-medium">{{ $schedule->course->course_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Section:</span>
                                <span class="font-medium">{{ $schedule->section->section_name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-semibold mb-2">Schedule Information</h3>
                        <div class="grid grid-cols-1 gap-2">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Day:</span>
                                <span class="font-medium">{{ $schedule->day }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Time:</span>
                                <span class="font-medium">
                                    {{ \Carbon\Carbon::parse($schedule->starting_time)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($schedule->ending_time)->format('h:i A') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Duration:</span>
                                <span class="font-medium">
                                    @php
                                        $start = \Carbon\Carbon::parse($schedule->starting_time);
                                        $end = \Carbon\Carbon::parse($schedule->ending_time);
                                        $diffInMinutes = $end->diffInMinutes($start);
                                        $hours = floor($diffInMinutes / 60);
                                        $minutes = $diffInMinutes % 60;
                                        echo $hours > 0 ? "$hours hour(s) " : "";
                                        echo $minutes > 0 ? "$minutes minute(s)" : "";
                                    @endphp
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-semibold mb-2">Instructor Information</h3>
                        <div class="grid grid-cols-1 gap-2">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Name:</span>
                                <span class="font-medium">{{ $schedule->instructor->first_name ?? 'N/A' }} {{ $schedule->instructor->last_name ?? '' }}</span>
                            </div>
                            @if(isset($schedule->instructor->email))
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Email:</span>
                                <span class="font-medium">{{ $schedule->instructor->email }}</span>
                            </div>
                            @endif
                            @if(isset($schedule->instructor->phone))
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Phone:</span>
                                <span class="font-medium">{{ $schedule->instructor->phone }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-semibold mb-2">Room Information</h3>
                        <div class="grid grid-cols-1 gap-2">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Room:</span>
                                <span class="font-medium">{{ $schedule->room->roomname ?? 'N/A' }}</span>
                            </div>
                            @if(isset($schedule->room->capacity))
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Capacity:</span>
                                <span class="font-medium">{{ $schedule->room->capacity }} students</span>
                            </div>
                            @endif
                            @if(isset($schedule->room->type))
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Type:</span>
                                <span class="font-medium">{{ $schedule->room->type }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <div>Created: {{ $schedule->created_at->format('M d, Y h:i A') }}</div>
                        <div>Last Updated: {{ $schedule->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('schedules.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Schedules
                </a>
            </div>
        </div>
    </div>
</x-app-layout>