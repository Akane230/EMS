<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students - {{ $instructor->first_name }} {{ $instructor->last_name }}</title>
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
            font-size: 24px;
        }

        .header h2 {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 16px;
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

        .section-block {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-header {
            background-color: #4f46e5;
            color: white;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .section-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .section-info {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .students-table th {
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

        .students-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
        }

        .students-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .students-table tr:hover {
            background-color: #f3f4f6;
        }

        .student-id {
            font-weight: 600;
            color: #4f46e5;
        }

        .student-name {
            font-weight: 500;
        }

        .courses-list {
            font-size: 10px;
            color: #666;
            line-height: 1.3;
        }

        .course-item {
            margin-bottom: 3px;
        }

        .course-code {
            font-weight: 600;
            color: #4f46e5;
        }

        .no-students {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-style: italic;
            background-color: #f9fafb;
            border-radius: 6px;
        }

        .summary {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 15px;
            margin-top: 30px;
        }

        .summary h3 {
            margin: 0 0 10px 0;
            color: #0369a1;
            font-size: 16px;
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #0369a1;
            display: block;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                padding: 0;
            }

            .section-block {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>All Students Report</h1>
        <h2>Instructor: {{ $instructor->first_name }} {{ $instructor->last_name }}</h2>
    </div>

    <div class="instructor-info">
        <h3>Instructor Information</h3>
        <p><strong>Name:</strong> {{ $instructor->first_name }} {{ $instructor->last_name }}</p>
        <p><strong>Generated:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    @php
    $totalStudents = 0;
    $totalSections = count($studentsBySection);
    @endphp

    @if(count($studentsBySection) > 0)
    @foreach($studentsBySection as $sectionName => $students)
    @php
    $totalStudents += count($students);
    @endphp

    <div class="section-block">
        <div class="section-header">
            <h3>{{ $sectionName }}</h3>
            <div class="section-info">
                {{ count($students) }} student{{ count($students) != 1 ? 's' : '' }} enrolled
            </div>
        </div>

        @if(count($students) > 0)
        <table class="students-table">
            <thead>
                <tr>
                    <th style="width: 8%;">#</th>
                    <th style="width: 15%;">Student ID</th>
                    <th style="width: 25%;">Name</th>
                    <th style="width: 32%;">Enrolled Courses</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="student-id">{{ $student->id }}</td>
                    <td class="student-name">{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>
                        <div class="courses-list">
                            @foreach($student->enrollments as $enrollment)
                            <div class="course-item">
                                <span class="course-code">{{ $enrollment->schedule->course_code }}</span>
                                - {{ $enrollment->schedule->course->course_name ?? 'N/A' }}
                                ({{ $enrollment->schedule->course->credits ?? 0 }} units)
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-students">
            No students enrolled in this section.
        </div>
        @endif
    </div>

    @if(!$loop->last)
    <div style="margin-bottom: 20px;"></div>
    @endif
    @endforeach

    <div class="summary">
        <h3>Summary Statistics</h3>
        <div class="summary-stats">
            <div class="stat-item">
                <span class="stat-number">{{ $totalSections }}</span>
                <span class="stat-label">Total Sections</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $totalStudents }}</span>
                <span class="stat-label">Total Students</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ number_format($totalStudents / max($totalSections, 1), 1) }}</span>
                <span class="stat-label">Avg per Section</span>
            </div>
        </div>
    </div>
    @else
    <div class="no-students" style="margin-top: 50px; padding: 50px;">
        <h3 style="color: #9ca3af; margin-bottom: 15px;">No Students Found</h3>
        <p>This instructor currently has no students enrolled in any courses.</p>
    </div>
    @endif

    <div class="footer">
        <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }} | All Students Report - {{ $instructor->first_name }} {{ $instructor->last_name }}</p>
        <p>This document contains confidential student information. Handle with care and in accordance with privacy policies.</p>
    </div>
</body>

</html>