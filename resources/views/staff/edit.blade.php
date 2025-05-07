<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Staff Member') }}
            </h2>
            <a href="{{ route('staff.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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

                    <form action="{{ route('staff.update', $staff->staff_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="staff_id" :value="__('Staff ID')" />
                            <x-text-input id="staff_id" class="block mt-1 w-full" type="text" name="staff_id" :value="old('staff_id', $staff->staff_id)" required />
                            <x-input-error :messages="$errors->get('staff_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $staff->first_name)" required />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $staff->last_name)" required />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$staff->email" required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select id="gender" name="gender" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ $staff->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $staff->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $staff->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="$staff->date_of_birth" required />
                            </div>
                        </div>

                        <div class="mb-4">
                            <h3 class="font-semibold mb-2">Address Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="country" :value="__('Country')" />
                                    <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="$staff->country" />
                                </div>
                                <div>
                                    <x-input-label for="province" :value="__('Province/State')" />
                                    <x-text-input id="province" class="block mt-1 w-full" type="text" name="province" :value="$staff->province" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="city" :value="__('City')" />
                                    <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="$staff->city" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="street" :value="__('Street Address')" />
                                    <x-text-input id="street" class="block mt-1 w-full" type="text" name="street" :value="$staff->street" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="zipcode" :value="__('Zipcode/Postal Code')" />
                            <x-text-input id="zipcode" class="block mt-1 w-full" type="text" name="zipcode" :value="$staff->zipcode" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="contact_number" :value="__('Contact Number')" />
                            <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" :value="$staff->contact_number" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>