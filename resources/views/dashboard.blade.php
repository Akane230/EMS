<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-medium">Welcome to the Enrollment Management System</h3>
                <p>Select a module below to manage your data</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Students Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Students</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Manage student records including personal information and enrollment details.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ \App\Models\Student::count() }} Records
                            </span>
                            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Manage
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Courses Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Courses</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Manage course information including course codes, titles, descriptions, and unit counts.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ \App\Models\Course::count() }} Records
                            </span>
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Manage
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Staff Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Staff</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Manage staff information including teachers and administrative personnel.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ \App\Models\Staff::count() }} Records
                            </span>
                            <a href="{{ route('staff.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>