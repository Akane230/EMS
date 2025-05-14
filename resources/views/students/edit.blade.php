<x-app-layout>
    <x-slot name="title">
        Edit Student
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Edit Student</div>
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

        <div class="module-card" id="edit-container">
            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Student ID</label>
                    <input type="text" value="{{ $student->id }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 bg-gray-100 dark:bg-gray-800" disabled readonly>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Gender</label>
                        <select name="gender" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $student->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Country</label>
                        <input type="text" name="country" value="{{ old('country', $student->country) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Province</label>
                        <input type="text" name="province" value="{{ old('province', $student->province) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">City</label>
                        <input type="text" name="city" value="{{ old('city', $student->city) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Street</label>
                        <input type="text" name="street" value="{{ old('street', $student->street) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Zip Code</label>
                        <input type="text" name="zipcode" value="{{ old('zipcode', $student->zipcode) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="Regular" {{ old('status', $student->status) === 'Regular' ? 'selected' : '' }}>Regular</option>
                            <option value="Irregular" {{ old('status', $student->status) === 'Irregular' ? 'selected' : '' }}>Irregular</option>
                            <option value="Active" {{ old('status', $student->status) === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $student->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('students.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition"
                        id="edit-update">
                        Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>