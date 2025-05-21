<x-app-layout title="Instructor Details">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl">Instructor Details</h2>
            <a href="{{ route('instructors.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Back to Instructors
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="module-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-medium mb-2">Basic Information</h3>
                    <div class="space-y-2">
                        <p><span class="font-semibold">ID:</span> {{ $instructor->id }}</p>
                        <p><span class="font-semibold">Name:</span> {{ $instructor->first_name }} {{ $instructor->last_name }}</p>
                        <p><span class="font-semibold">Gender:</span> {{ $instructor->gender }}</p>
                        <p><span class="font-semibold">Date of Birth:</span> {{ \Carbon\Carbon::parse($instructor->date_of_birth)->format('M d, Y') }}</p>
                        <p><span class="font-semibold">Age:</span> {{ \Carbon\Carbon::parse($instructor->date_of_birth)->age }} years</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium mb-2">Contact Information</h3>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Email:</span> {{ $instructor->email }}</p>
                        <p><span class="font-semibold">Contact Number:</span> {{ $instructor->contact_number ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Status:</span> 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Active
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-medium mb-2">Address Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p><span class="font-semibold">Country:</span> {{ $instructor->country ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Province:</span> {{ $instructor->province ?? 'N/A' }}</p>
                    <p><span class="font-semibold">City:</span> {{ $instructor->city ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Street:</span> {{ $instructor->street ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Zip Code:</span> {{ $instructor->zipcode ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="flex space-x-4 mt-8">
                <a href="{{ route('instructors.edit', $instructor->id) }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition">
                    Edit Instructor <i class="fas fa-edit ml-2"></i>
                </a>
                <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition" onclick="return confirm('Are you sure you want to delete this instructor?')">
                        Delete Instructor <i class="fas fa-trash ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>