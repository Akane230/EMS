<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule - {{ $instructor->first_name }} {{ $instructor->last_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #4f46e5;
            font-size: 26px;
        }

        .header h2 {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 18px;
            font-weight: normal;
        }

        .instructor-info {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #4f46e5;
        }

        .instructor-info h3 {
            margin: 0 0 8px 0;
            color: #4f46e5;
            font-size: 16px;
        }

        .instructor-info p {
            margin: 3px 0;
            color: #666;
        }

        .term-info {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .term-info h3 {
            margin: 0 0 8px 0;
            color: #0369a1;
            font-size: 16px;
        }

        .day-block {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .day-header {
            background-color: #4f46e5;
            color: white;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .day-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .day-count {
            font-size: 14px;
            opacity: 0.9;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .schedule-table th {
            background-color: #f8fafc;
            color: #374151;
            font-weight: 600;
            padding: 12px 8px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .schedule-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
            vertical-align: top;
        }

        .schedule-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .time-slot {
            font-weight: 600;
            color: #4f46e5;
            font-size: 12px;
        }

        .course-code {
            font-weight: 600;
            color: #4f46e5;
            font-size: 12px;
        }

        .course-name {
            font-weight: 500;
            margin-top: 2px;
        }

        .course-details {
            color: #666;
            font-size: 10px;
            margin-top: 3px;
            line-height: 1.3;
        }

        .section-info {
            color: #0ea5e9;
            font-weight: 500;
        }

        .room-info {
            color: #059669;
            font-weight: 500;
        }

        .credits-badge {
            background-color: #fef3c7;
            color: #92400e;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .course-type {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            margin-left: 5px;
        }

        .no-schedule {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-style: italic;
            background-color: #f9fafb;
            border-radius: 6px;
        }

        .summary {
            background-color: #f0fdf4;
            border: 1px solid #16a34a;
            border-radius: 8px;
            padding: 15px;
            margin-top: 30px;
        }

        .summary h3 {
            margin: 0 0 15px 0;
            color: #166534;
            font-size: 16px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .summary-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 6px;
        }

        .summary-number {
            font-size: 20px;
            font-weight: bold;
            color: #166534;
            display: block;
        }

        .summary-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 10px;
        }

        .legend {
            background-color: #f9fafb;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .legend h4 {
            margin: 0 0 10px 0;
            color: #374151;
            font-size: 14px;
        }

        .legend-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            font-size: 11px;
        }

        .legend-item {
            display: flex;
            align-items: center;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            margin-right: 8px;
        }

        @media print {
            body {
                padding: 0;
            }

            .day-block {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Class Schedule</h1>
        <h2>{{ $instructor->first_name }} {{ $instructor->last_name }}</h2>
    </div>

    <div class="instructor-info">
        <h3>Instructor Information</h3>
        <p><strong>Name:</strong> {{ $instructor->first_name }} {{ $instructor->last_name }}</p>
        <p><strong>Generated:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    @if($currentTerm)
    <div class="term-info">
        <h3>Academic Term</h3>
        <p><strong>Term:</strong> {{ $currentTerm->schoolyear_semester }}</p>
        <p><strong>Status:</strong>
            <span style="color: {{ $currentTerm->status == 'active' ? '#059669' : '#d97706' }}; font-weight: 600;">
                {{ ucfirst($currentTerm->status) }}
            </span>
        </p>
    </div>
    @endif

    <div class="legend">
        <h4>Schedule Legend</h4>
        <div class="legend-grid">
            <div class="legend-item">
                <div class="legend-color" style="background-color: #4f46e5;"></div>
                Course Code & Time
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #0ea5e9;"></div>
                Section Information
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #059669;"></div>
                Room Assignment
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #d97706;"></div>
                Credits
            </div>
        </div>
    </div>

    @php
    $totalClasses = 0;
    $totalCredits = 0;
    $uniqueCourses = [];
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    @endphp

    @if(count($schedulesByDay) > 0)
    @foreach($days as $day)
    @if(isset($schedulesByDay[$day]))
    @php
    $daySchedules = $schedulesByDay[$day];
    $totalClasses += count($daySchedules);
    @endphp

    <div class="day-block">
        <div class="day-header">
            <h3>{{ $day }}</h3>
            <div class="day-count">{{ count($daySchedules) }} class{{ count($daySchedules) != 1 ? 'es' : '' }}</div>
        </div>

        <table class="schedule-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Time</th>
                    <th style="width: 20%;">Course</th>
                    <th style="width: 25%;">Course Name</th>
                    <th style="width: 15%;">Section</th>
                    <th style="width: 15%;">Room</th>
                    <th style="width: 10%;">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daySchedules->sortBy('starting_time') as $schedule)
                @php
                if (!in_array($schedule->course_code, $uniqueCourses)) {
                $uniqueCourses[] = $schedule->course_code;
                $totalCredits += $schedule->course->credits ?? 0;
                }
                @endphp
                <tr>
                    <td>
                        <div class="time-slot">
                            {{ date('g:i A', strtotime($schedule->starting_time)) }} - {{ date('g:i A', strtotime($schedule->ending_time)) }}
                        </div>
                    </td>
                    <td>
                        <div class="course-code">{{ $schedule->course_code }}</div>
                    </td>
                    <td>
                        <div class="course-name">{{ $schedule->course->course_name ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="section-info">{{ $schedule->section->section_name ?? 'N/A' }}</div>
                        @if($schedule->section && $schedule->section->program)
                        <div class="course-details">{{ $schedule->section->program->program_name }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="room-info">{{ $schedule->room->roomname ?? 'TBA' }}</div>
                    </td>
                    <td>
                        <div>
                            <span class="credits-badge">{{ $schedule->course->credits ?? 0 }} units</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @endforeach

    <div class="summary">
        <h3>Schedule Summary</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="summary-number">{{ count($uniqueCourses) }}</span>
                <span class="summary-label">Unique Courses</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ $totalClasses }}</span>
                <span class="summary-label">Total Classes</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ $totalCredits }}</span>
                <span class="summary-label">Total Credits</span>
            </div>
            <div class="summary-item">
                <span class="summary-number">{{ count($schedulesByDay) }}</span>
                <span class="summary-label">Teaching Days</span>
            </div>
        </div>
    </div>
    @else
    <div class="no-schedule" style="margin-top: 50px; padding: 50px;">
        <h3 style="color: #9ca3af; margin-bottom: 15px;">No Schedule Available</h3>
        <p>No classes are currently scheduled for this instructor in the selected term.</p>
    </div>
    @endif

    <div class="footer">
        <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }} | Class Schedule - {{ $instructor->first_name }} {{ $instructor->last_name }}</p>
        @if($currentTerm)
        <p>Academic Term: {{ $currentTerm->schoolyear_semester }}</p>
        @endif
        <p>This document contains confidential scheduling information. Handle with care.</p>
    </div>
</body>

</html>