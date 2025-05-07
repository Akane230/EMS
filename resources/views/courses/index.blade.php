<x-app-layout>
    <x-slot name="header">
        <div class="mb-4">
            <form action="{{ route('courses.index') }}" method="GET">
                <div class="flex">
                    <x-text-input 
                        type="text" 
                        name="search" 
                        class="block w-full"
                        placeholder="Search..." 
                        value="{{ request('search') }}"
                    />
                    <x-primary-button class="ml-2">
                        Search
                    </x-primary-button>
                    @if(request('search'))
                        <a href="{{ route('courses.index') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Courses') }}
            </h2>
            <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Add New Course
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($message = Session::get('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course Code</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Credits</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach ($courses as $course)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->course_code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->course_name }}</td>
                                        <td class="px-6 py-4">{{ $course->description ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->credits }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('courses.destroy', $course->course_id) }}" method="POST">
                                                <a href="{{ route('courses.edit', $course->course_id) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-200 mr-3">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $courses->links() }} <!-- Change variable name for courses/staff -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>