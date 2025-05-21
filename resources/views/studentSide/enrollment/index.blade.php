<x-studentapp-layout>
    <x-slot name="title">My Enrollments</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">My Enrollments</h2>
                </div>

                @if($enrollments->isEmpty())
                    <div class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-200 p-4 rounded-lg">
                        You have no enrollments yet. 
                        <a href="{{ route('studentSide.enrollment.create') }}" class="font-medium hover:underline">Enroll now</a>
                    </div>
                @else
                    @foreach($enrollments as $termId => $termEnrollments)
                        @php $term = $termEnrollments->first()->term; @endphp
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                {{ $term->name }} ({{ $term->start_date->format('Y') }})
                            </h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Section</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($termEnrollments as $enrollment)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $enrollment->course->name }} ({{ $enrollment->course->code }})
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $enrollment->section->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $enrollment->created_at->format('M d, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-studentapp-layout>