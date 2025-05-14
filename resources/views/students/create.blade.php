<x-app-layout>
    <x-slot name="title">
        Add Student
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Add Student</div>
    </div>

    <div class="max-w-4xl mx-auto">
        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
            <p class="font-bold">Error!</p>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="module-card">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Gender</label>
                        <select name="gender" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Address Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">Country</label>
                            <input type="text" name="country" value="{{ old('country') }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Province/State</label>
                            <input type="text" name="province" value="{{ old('province') }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">City</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Street Address</label>
                            <input type="text" name="street" value="{{ old('street') }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1">Zipcode/Postal Code</label>
                        <input type="text" name="zipcode" value="{{ old('zipcode') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select Status</option>
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="Regular" {{ old('status') == 'Regular' ? 'selected' : '' }}>Regular</option>
                            <option value="Irregular" {{ old('status') == 'Irregular' ? 'selected' : '' }}>Irregular</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">User ID (Optional)</label>
                        <input type="number" name="user_id" value="{{ old('user_id') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('students.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                        Create Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>