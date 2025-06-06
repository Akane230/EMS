<x-app-layout>
    <x-slot name="title">
        Create Section
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Create New Section</div>
        <div class="dashboard-subtitle">Add a new section to the system</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('sections.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Sections
            </a>
        </div>

        <div class="module-card">
            <form action="{{ route('sections.store') }}" method="POST">
                @csrf

                @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-6">
                    <label for="section_name" class="block text-sm font-medium mb-2">Section Name</label>
                    <input type="text" id="section_name" name="section_name" value="{{ old('section_name') }}" required
                        maxlength="20"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Enter section name">
                    <p class="text-sm text-gray-500 mt-1">Maximum 20 characters</p>
                </div>

                <div class="mb-6">
                    <label for="program_id" class="block text-sm font-medium mb-2">Program</label>
                    <select id="program_id" name="program_id" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select Program</option>
                        @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->program_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="module-action">
                        Create Section <i class="fas fa-save ml-2"></i>
                    </button>
                    <a href="{{ route('sections.index') }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>