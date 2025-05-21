<x-studentapp-layout>
    <x-slot name="title">
        Class Schedule
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Class Schedule</div>
        <div class="dashboard-subtitle">{{ $currentTerm->schoolyear_semester }}</div>
    </div>

    <div class="mb-6">      
        <a href="{{ route('studentSide.dashboard') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
        </a>
    </div>

    @if($enrollments->isEmpty())
        <div class="alert alert-info">
            <div class="alert-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">No Enrollments Found</div>
                <div class="alert-message">You are not enrolled in any courses for this term.</div>
            </div>
            <div class="alert-action">
                <a href="{{ route('studentSide.enrollment.create') }}" class="btn-primary">
                    Enroll Now
                </a>
            </div>
        </div>
    @else
        <!-- Schedule List View -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-4">Your Schedule</h3>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($enrollments as $enrollment)
                            @if($enrollment->schedule)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $enrollment->course->course_code }}</div>
                                        <div class="text-sm text-gray-500">{{ $enrollment->course->course_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $enrollment->schedule->day }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ date('h:i A', strtotime($enrollment->schedule->starting_time)) }} - 
                                            {{ date('h:i A', strtotime($enrollment->schedule->ending_time)) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $enrollment->schedule->room->room_name ?? 'TBA' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $enrollment->schedule->instructor->name ?? 'TBA' }}
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No schedules found for this term.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Download COR Button -->
        <div class="mt-6 flex justify-end">
            <a href="{{ route('studentSide.enrollment.download.cor') }}" class="btn-primary">
                <i class="fas fa-download mr-2"></i> Download Certificate of Registration
            </a>
        </div>
    @endif
</x-studentapp-layout>

@push('styles')
<style>
    .btn-primary {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background-color: #4F46E5;
        color: white;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #4338CA;
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background-color: #6B7280;
        color: white;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .btn-secondary:hover {
        background-color: #4B5563;
    }
</style>
@endpush