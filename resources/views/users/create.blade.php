<x-app-layout>
    <x-slot name="title">
        Create User
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Create New User</div>
        <div class="dashboard-subtitle">Add a new user to the system</div>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-end mb-6">
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Users
            </a>
        </div>

        <div class="module-card">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded">
                    <div class="font-medium">Please fix the following errors:</div>
                    <ul class="mt-3 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        required>
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        required>
                </div>

                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium mb-2">Role</label>
                    <select name="role" id="role"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        required>
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select a role</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Instructor" {{ old('role') == 'Instructor' ? 'selected' : '' }}>Instructor</option>
                        <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>Student</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="avatar" class="block text-sm font-medium mb-2">Avatar (Optional)</label>
                    <input type="file" name="avatar" id="avatar"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        accept="image/*">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max file size: 2MB. Accepted formats: JPG, PNG, GIF</p>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        required>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 input-padding"
                        required>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="module-action">
                        Create User <i class="fas fa-save ml-2"></i>
                    </button>
                    <a href="{{ route('users.index') }}" class="py-2 px-4 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>