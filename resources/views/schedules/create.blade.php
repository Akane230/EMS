<x-app-layout>
    <x-slot name="title">
        Add New Schedule
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Add New Schedule</div>
        <div class="dashboard-subtitle">Create a new class schedule in the system</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            @if($errors->any())
            <div class="mb-4 px-4 py-2 border-l-4 border-red-500 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('schedules.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="day" class="block mb-2 text-sm font-medium">Day</label>
                        <select id="day" name="day" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding" required>
                            <option value="">Select Day</option>
                            @foreach($days as $day)
                            <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="course_code" class="block mb-2 text-sm font-medium">Course</label>
                        <select id="course_code" name="course_code" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->course_code }}" {{ old('course_code') == $course->course_code ? 'selected' : '' }}>
                                {{ $course->course_code }} - {{ $course->course_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="section_id" class="block mb-2 text-sm font-medium">Section</label>
                        <select id="section_id" name="section_id" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->section_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="instructor_id" class="block mb-2 text-sm font-medium">Instructor</label>
                        <select id="instructor_id" name="instructor_id" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding" required>
                            <option value="">Select Instructor</option>
                            @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->first_name }} {{ $instructor->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="room_id" class="block mb-2 text-sm font-medium">Room</label>
                        <select id="room_id" name="room_id" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding" required>
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->roomname }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="starting_time" class="block mb-2 text-sm font-medium">Starting Time</label>
                        <input type="time" id="starting_time" name="starting_time" value="{{ old('starting_time') }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding" required>
                    </div>

                    <div>
                        <label for="ending_time" class="block mb-2 text-sm font-medium">Ending Time</label>
                        <input type="time" id="ending_time" name="ending_time" value="{{ old('ending_time') }}" class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding" required>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('schedules.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Schedules
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        <i class="fas fa-save mr-2"></i> Save Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>