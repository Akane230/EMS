<x-studentapp-layout>
    <x-slot name="title">
        Select Program
    </x-slot>

    <div class="dashboard-header">
        <div class="dashboard-title">Program Selection</div>
        <div class="dashboard-subtitle">Please select your degree program for {{ $currentTerm->schoolyear_semester }}</div>
    </div>

    <div class="mb-6">      
        <a href="{{ route('studentSide.enrollment.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to Enrollments
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('studentSide.enrollment.store_program') }}" method="POST" class="space-y-6">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="card-title">Available Programs</div>
            </div>
            <div class="card-body">
                @if($programs->isEmpty())
                    <div class="empty-state py-8">
                        <div class="empty-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <p>No programs available for enrollment</p>
                    </div>
                @else
                    <div class="space-y-4">
                        <select name="program_id" id="program_id" required class="focus:ring-primary-500 text-primary-600 border-gray-300 block w-full mt-1 rounded-md">
                            <option value="">Select a Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->program_name }} - {{ $program->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn-primary">
                Continue to Course Selection
            </button>
        </div>
    </form>
</x-studentapp-layout>