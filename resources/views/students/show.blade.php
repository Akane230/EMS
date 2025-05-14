<x-app-layout title="Student Details">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl">Student Details</h2>
            <a href="{{ route('students.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Back to Students
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="module-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-medium mb-2">Basic Information</h3>
                    <div class="space-y-2">
                        <p><span class="font-semibold">ID:</span> {{ $student->id }}</p>
                        <p><span class="font-semibold">Name:</span> {{ $student->first_name }} {{ $student->last_name }}</p>
                        <p><span class="font-semibold">Gender:</span> {{ $student->gender }}</p>
                        <p><span class="font-semibold">Date of Birth:</span> {{ \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') }}</p>
                        <p><span class="font-semibold">Age:</span> {{ \Carbon\Carbon::parse($student->date_of_birth)->age }} years</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium mb-2">Contact Information</h3>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Email:</span> {{ $student->email }}</p>
                        <p><span class="font-semibold">Contact Number:</span> {{ $student->contact_number ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Status:</span> 
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
                        </p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-medium mb-2">Address Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p><span class="font-semibold">Country:</span> {{ $student->country ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Province:</span> {{ $student->province ?? 'N/A' }}</p>
                    <p><span class="font-semibold">City:</span> {{ $student->city ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Street:</span> {{ $student->street ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Zip Code:</span> {{ $student->zipcode ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="flex space-x-4 mt-8">
                <a href="{{ route('students.edit', $student->id) }}" class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition">
                    Edit Student
                </a>
                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition" onclick="return confirm('Are you sure you want to delete this student?')">
                        Delete Student
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>