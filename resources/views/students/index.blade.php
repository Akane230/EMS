<x-app-layout>
    <x-slot name="title">
        Students Management
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Students Management</div>
        <div class="dashboard-subtitle">Manage all students in the system</div>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-6 border-l-4 border-green-500 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex items-center space-x-4 add-export-container">
        <a href="{{ route('students.create') }}" class="module-action">
            Add Student <i class="fas fa-plus ml-2"></i>
        </a>
        <a href="{{ route('students.export.pdf') }}" class="px-4 py-2 bg-green-600 text-black rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
            <i class="fas fa-file-pdf mr-2"></i> All Students PDF
        </a>

    </div>
    <div class="max-w-7xl mx-auto">
        <div class="module-card">
            <div class="mb-6">
                <form action="{{ route('students.index') }}" method="GET">
                    <div class="flex">
                        <div class="relative flex-grow">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Search students...">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button type="submit" class="ml-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                            Search
                        </button>
                        <a href="{{ route('students.index') }}" class="ml-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
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
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($students as $student)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->user_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $student->first_name }} {{ $student->last_name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $student->gender }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';

                                if ($student->status == 'Active') {
                                $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                } elseif ($student->status == 'Irregular') {
                                $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                } elseif ($student->status == 'Suspended') {
                                $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                } elseif ($student->status == 'Inactive') {
                                $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                }
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $student->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('students.export.individual.pdf', $student->id) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200" title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 delete-button" onclick="return confirm('Are you sure you want to delete this student?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No students found{{ request('search') ? ' matching "' . request('search') . '"' : '' }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</x-app-layout>