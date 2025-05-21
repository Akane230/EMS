<x-studentapp-layout>
    <x-slot name="title">
        Edit Profile
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Edit Profile</div>
        <div class="dashboard-subtitle">Update your personal information</div>
    </div>

    <form action="{{ route('student.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-6">
            <div class="card-header">
                <div class="card-title">Personal Information</div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="first_name" id="first_name" required
                            value="{{ old('first_name', $user->first_name) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name" required
                            value="{{ old('last_name', $user->last_name) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" required
                            value="{{ old('email', $user->email) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" required
                            value="{{ old('phone_number', $student->phone_number ?? '') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" required
                            value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <select name="gender" id="gender" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <option value="Male" {{ (old('gender', $student->gender ?? '') == 'Male' ? 'selected' : '') }}>Male</option>
                            <option value="Female" {{ (old('gender', $student->gender ?? '') == 'Female' ? 'selected' : '') }}>Female</option>
                            <option value="Other" {{ (old('gender', $student->gender ?? '') == 'Other' ? 'selected' : '') }}>Other</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" name="address" id="address" required
                            value="{{ old('address', $student->address ?? '') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-6">
            <div class="card-header">
                <div class="card-title">Academic Information</div>
            </div>
            <div class="card-body">
                @if(!$student || !$student->program_id)
                    <div class="mb-4">
                        <label for="program_id" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                        <select name="program_id" id="program_id" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <option value="">Select Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->program_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                        <p class="text-gray-900">{{ $student->program->program_name }}</p>
                        <input type="hidden" name="program_id" value="{{ $student->program_id }}">
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">
                Update Profile
            </button>
        </div>
    </form>
</x-studentapp-layout>