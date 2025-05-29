<x-studentapp-layout>

    <x-slot name="title">
        Terms Management
    </x-slot>

    <div class="dashboard">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Edit Profile</h1>
            <p class="dashboard-subtitle">Update your personal information and account settings</p>
        </div>

        @if(session('success'))
        <div class="enrollment-alert success">
            <i class="fas fa-check-circle alert-icon"></i>
            <div class="alert-content">
                <div class="alert-title">Success!</div>
                <div class="alert-message">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="enrollment-alert" style="background-color: rgba(239, 68, 68, 0.1); border-left-color: var(--danger);">
            <i class="fas fa-exclamation-triangle alert-icon" style="color: var(--danger);"></i>
            <div class="alert-content">
                <div class="alert-title" style="color: var(--danger);">Please fix the following errors:</div>
                <div class="alert-message">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('studentSide.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="cards-grid">
                <!-- Personal Information Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user mr-2"></i>
                            Personal Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Profile Picture -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Profile Picture</label>
                            <div class="flex items-center space-x-4">
                                @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                    alt="Current Avatar"
                                    class="avatar-image">
                                @else
                                <div class="avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <input type="file"
                                        name="avatar"
                                        id="avatar"
                                        accept="image/*"
                                        class="input-padding border border-gray-300 rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium mb-2">First Name *</label>
                                <input type="text"
                                    name="first_name"
                                    id="first_name"
                                    value="{{ old('first_name', $student->first_name) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium mb-2">Last Name *</label>
                                <input type="text"
                                    name="last_name"
                                    id="last_name"
                                    value="{{ old('last_name', $student->last_name) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="email" class="block text-sm font-medium mb-2">Email Address *</label>
                                <input type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $student->email) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                            <div>
                                <label for="contact_number" class="block text-sm font-medium mb-2">Contact Number *</label>
                                <input type="text"
                                    name="contact_number"
                                    id="contact_number"
                                    value="{{ old('contact_number', $student->contact_number) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium mb-2">Date of Birth *</label>
                                <input type="date"
                                    name="date_of_birth"
                                    id="date_of_birth"
                                    value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium mb-2">Gender *</label>
                                <select name="gender"
                                    id="gender"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Address Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="country" class="block text-sm font-medium mb-2">Country *</label>
                                <input type="text"
                                    name="country"
                                    id="country"
                                    value="{{ old('country', $student->country) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                            <div>
                                <label for="province" class="block text-sm font-medium mb-2">Province/State *</label>
                                <input type="text"
                                    name="province"
                                    id="province"
                                    value="{{ old('province', $student->province) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="city" class="block text-sm font-medium mb-2">City *</label>
                                <input type="text"
                                    name="city"
                                    id="city"
                                    value="{{ old('city', $student->city) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                            <div>
                                <label for="zipcode" class="block text-sm font-medium mb-2">Zip Code *</label>
                                <input type="text"
                                    name="zipcode"
                                    id="zipcode"
                                    value="{{ old('zipcode', $student->zipcode) }}"
                                    class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="street" class="block text-sm font-medium mb-2">Street Address *</label>
                            <input type="text"
                                name="street"
                                id="street"
                                value="{{ old('street', $student->street) }}"
                                class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Change Card -->
            <div class="card mt-6">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lock mr-2"></i>
                        Change Password
                    </h3>
                    <small class="text-gray-500">Leave blank if you don't want to change your password</small>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium mb-2">Current Password</label>
                            <input type="password"
                                name="current_password"
                                id="current_password"
                                class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium mb-2">New Password</label>
                            <input type="password"
                                name="new_password"
                                id="new_password"
                                class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium mb-2">Confirm New Password</label>
                            <input type="password"
                                name="new_password_confirmation"
                                id="new_password_confirmation"
                                class="w-full input-padding border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('studentSide.profile.show') }}"
                    class="btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <style>
        .grid {
            display: grid;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .gap-4 {
            gap: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .block {
            display: block;
        }

        .justify-end {
            justify-content: flex-end;
        }

        .space-x-4>*+* {
            margin-left: 1rem;
        }

        @media (min-width: 768px) {
            .md\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
    </style>
</x-studentapp-layout>