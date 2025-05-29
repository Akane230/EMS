<x-app-layout>
    <x-slot name="title">
        Instructors Management
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Instructors Management</div>
        <div class="dashboard-subtitle">Manage all instructors in the system</div>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-6 border-l-4 border-green-500 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex items-center space-x-4 add-export-container">
        <a href="{{ route('instructors.create') }}" class="module-action">
            Add Instructor <i class="fas fa-plus ml-2"></i>
        </a>
        <a href="{{ route('instructors.export.pdf') }}" class="px-4 py-2 bg-green-600 text-black rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
            <i class="fas fa-file-pdf mr-2"></i> Export PDF
        </a>

    </div>

    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <form action="{{ route('instructors.index') }}" method="GET">
                    <div class="flex">
                        <div class="relative flex-grow">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Search instructors...">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button type="submit" class="ml-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                            Search
                        </button>
                        <a href="{{ route('instructors.index') }}" class="ml-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
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
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">User ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Gender</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($instructors as $instructor)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $instructor->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $instructor->user_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $instructor->first_name }} {{ $instructor->last_name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($instructor->date_of_birth)->age }} years
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $instructor->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                $genderClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                if ($instructor->gender === 'Female') {
                                $genderClass = 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200';
                                } elseif ($instructor->gender === 'Other') {
                                $genderClass = 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200';
                                }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $genderClass }}">
                                    {{ $instructor->gender }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('instructors.export.individual.pdf', $instructor->id) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200" title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('instructors.show', $instructor->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('instructors.edit', $instructor->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200" onclick="return confirm('Are you sure you want to delete this instructor?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No instructors found{{ request('search') ? ' matching "' . request('search') . '"' : '' }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $instructors->links() }}
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('instructorsData', () => ({
                    showDeleteModal: false,
                    instructorToDelete: null,

                    confirmDelete(instructorId) {
                        this.instructorToDelete = instructorId;
                        this.showDeleteModal = true;
                    },

                    deleteInstructor() {
                        document.getElementById('delete-form-' + this.instructorToDelete).submit();
                        this.showDeleteModal = false;
                    },

                    cancelDelete() {
                        this.showDeleteModal = false;
                        this.instructorToDelete = null;
                    }
                }));
            });
        </script>
    </x-slot>
</x-app-layout>