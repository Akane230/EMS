<x-app-layout>
    <x-slot name="title">
        User Details
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">User Details</div>
        <div class="dashboard-subtitle">View user information</div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center space-x-4 add-export-container">
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Users
            </a>
            <a href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition">
                <i class="fas fa-edit mr-2"></i> Edit User
            </a>
        </div>

        <div class="module-card">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 h-24 w-24">
                    @if ($user->avatar)
                        <img class="h-24 w-24 rounded-full object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-24 w-24 rounded-full bg-primary-600 flex items-center justify-content">
                            <span class="text-white text-2xl font-medium mx-auto">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <div class="ml-6">
                    <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->getRoleBadgeClass() }}">
                        {{ $user->role }}
                    </span>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Account Information</h3>
                        <ul class="space-y-4">
                            <li class="flex">
                                <span class="text-sm font-medium w-32">Name:</span>
                                <span class="text-sm">{{ $user->name }}</span>
                            </li>
                            <li class="flex">
                                <span class="text-sm font-medium w-32">Email:</span>
                                <span class="text-sm">{{ $user->email }}</span>
                            </li>
                            <li class="flex">
                                <span class="text-sm font-medium w-32">Role:</span>
                                <span class="text-sm">{{ $user->role }}</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Login Information</h3>
                        <ul class="space-y-4">
                            <li class="flex">
                                <span class="text-sm font-medium w-32">Last Login:</span>
                                <span class="text-sm">{{ $user->last_login ? $user->last_login->format('M d, Y H:i') : 'Never' }}</span>
                            </li>
                            <li class="flex">
                                <span class="text-sm font-medium w-32">Failed Attempts:</span>
                                <span class="text-sm">{{ $user->failed_attempts ?? 0 }}</span>
                            </li>
                            <li class="flex">
                                <span class="text-sm font-medium w-32">Created At:</span>
                                <span class="text-sm">{{ $user->created_at->format('M d, Y H:i') }}</span>
                            </li>
                            <li class="flex">
                                <span class="text-sm font-medium w-32">Updated At:</span>
                                <span class="text-sm">{{ $user->updated_at->format('M d, Y H:i') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @if($user->role == 'Student' && $user->students->count() > 0)
            <div class="mt-6">
                <h3 class="text-lg font-medium mb-4">Student Information</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Student ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Program</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Year Level</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($user->students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->student_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->program }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->year_level }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if($user->role == 'Instructor' && $user->instructors->count() > 0)
            <div class="mt-6">
                <h3 class="text-lg font-medium mb-4">Instructor Information</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Employee ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Position</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($user->instructors as $instructor)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $instructor->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $instructor->employee_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $instructor->department }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $instructor->position }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if(Auth::id() !== $user->id)
            <div class="mt-6 flex justify-end">
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
                            onclick="return confirm('Are you sure you want to delete this user?')">
                        <i class="fas fa-trash mr-2"></i> Delete User
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>