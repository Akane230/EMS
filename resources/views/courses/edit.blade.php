<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Course') }}
            </h2>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p><strong>Error!</strong> Please check the form for errors.</p>
                            <ul class="list-disc pl-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('courses.update', $course->course_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="course_code" :value="__('Course Code')" />
                            <x-text-input id="course_code" class="block mt-1 w-full" type="text" name="course_code" :value="old('course_code', $course->course_code)" required />
                            <x-input-error :messages="$errors->get('course_code')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="course_name" :value="__('Course Name')" />
                            <x-text-input id="course_name" class="block mt-1 w-full" type="text" name="course_name" :value="old('course_name', $course->course_name)" required />
                            <x-input-error :messages="$errors->get('course_name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $course->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="credits" :value="__('Credits')" />
                            <x-text-input id="credits" class="block mt-1 w-full" type="number" name="credits" :value="old('credits', $course->credits)" required min="1" />
                            <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Course') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>