<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Section {{ $section->section_name }} - Student List</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #4f46e5;
            margin: 0 0 10px 0;
        }

        .header h2 {
            font-size: 16px;
            color: #666;
            margin: 0 0 5px 0;
            font-weight: normal;
        }

        .section-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .section-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .section-info td {
            padding: 5px 0;
            vertical-align: top;
        }

        .section-info .label {
            font-weight: bold;
            width: 120px;
            color: #4f46e5;
        }

        .instructor-info {
            background-color: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .instructor-info h3 {
            color: #4f46e5;
            margin: 0 0 10px 0;
            font-size: 14px;
        }

        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .students-table th {
            background-color: #4f46e5;
            color: white;
            padding: 12px 8px;
            border: 1px solid #4f46e5;
            font-weight: bold;
            text-align: left;
            font-size: 11px;
        }

        .students-table td {
            padding: 10px 8px;
            border: 1px solid #ddd;
            font-size: 11px;
        }

        .students-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .students-table tr:hover {
            background-color: #f0f9ff;
        }

        .student-name {
            font-weight: bold;
            color: #4f46e5;
        }

        .course-info {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        .summary {
            background-color: #f0f9ff;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .summary h3 {
            color: #4f46e5;
            margin: 0 0 10px 0;
            font-size: 14px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #4f46e5;
        }

        .summary-label {
            font-size: 10px;
            color: #666;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }

        .date-generated {
            text-align: right;
            margin-bottom: 20px;
            font-size: 10px;
            color: #666;
        }

        .no-students {
            text-align: center;
            padding: 40px;
            color: #666;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="date-generated">
        Generated on: {{ now()->format('F d, Y - h:i A') }}
    </div>

    <div class="header">
        <h1>STUDENT LIST</h1>
        <h2>Section {{ $section->section_name }}</h2>
    </div>

    <div class="section-info">
        <table>
            <tr>
                <td class="label">Section:</td>
                <td>{{ $section->section_name }}</td>
                <td class="label">Program:</td>
                <td>{{ $section->program->program_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Department:</td>
                <td>{{ $section->program->department->department_name ?? 'N/A' }}</td>
                <td class="label">Total Students:</td>
                <td><strong>{{ $students->count() }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="instructor-info">
        <h3>Instructor Information</h3>
        <p><strong>Name:</strong> {{ $instructor->first_name }} {{ $instructor->last_name }}</p>
        <p><strong>Email:</strong> {{ $instructor->email }}</p>
        <p><strong>Employee ID:</strong> {{ $instructor->employee_id ?? 'N/A' }}</p>
    </div>

    @if($students->count() > 0)
    <table class="students-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 15%;">Student ID</th>
                <th style="width: 25%;">Student Name</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 20%;">Enrolled Courses</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $student->id }}</td>
                <td>
                    <div class="student-name">{{ $student->first_name }} {{ $student->last_name }}</div>
                    @if($student->middle_name)
                    <div class="course-info">Middle: {{ $student->middle_name }}</div>
                    @endif
                </td>
                <td>{{ $student->email }}</td>
                <td>
                    @foreach($student->enrollments as $enrollment)
                    <div style="margin-bottom: 5px;">
                        <strong>{{ $enrollment->schedule->course_code }}</strong>
                        <div class="course-info">{{ $enrollment->schedule->course->course_name }}</div>
                        <div class="course-info">{{ $enrollment->schedule->course->credits }} credits</div>
                    </div>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Course Summary for this Section -->
    <div class="summary">
        <h3>Course Summary</h3>
        @php
        $courseStats = [];
        $totalCredits = 0;
        foreach($students as $student) {
        foreach($student->enrollments as $enrollment) {
        $courseCode = $enrollment->schedule->course_code;
        if (!isset($courseStats[$courseCode])) {
        $courseStats[$courseCode] = [
        'name' => $enrollment->schedule->course->course_name,
        'credits' => $enrollment->schedule->course->credits,
        'students' => 0
        ];
        }
        $courseStats[$courseCode]['students']++;
        $totalCredits += $enrollment->schedule->course->credits;
        }
        }
        @endphp

        @if(count($courseStats) > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="background-color: #f1f3f4;">
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Course Code</th>
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Course Name</th>
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Credits</th>
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Enrolled Students</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courseStats as $courseCode => $stats)
                <tr>
                    <td style="padding: 6px; border: 1px solid #ddd;">{{ $courseCode }}</td>
                    <td style="padding: 6px; border: 1px solid #ddd;">{{ $stats['name'] }}</td>
                    <td style="padding: 6px; border: 1px solid #ddd; text-align: center;">{{ $stats['credits'] }}</td>
                    <td style="padding: 6px; border: 1px solid #ddd; text-align: center;">{{ $stats['students'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <div style="margin-top: 15px;">
            <p><strong>Total Unique Courses:</strong> {{ count($courseStats) }}</p>
            <p><strong>Total Students:</strong> {{ $students->count() }}</p>
            <p><strong>Average Students per Course:</strong> {{ count($courseStats) > 0 ? round(array_sum(array_column($courseStats, 'students')) / count($courseStats), 1) : 0 }}</p>
        </div>
    </div>
    @else
    <div class="no-students">
        <h3>No Students Enrolled</h3>
        <p>This section currently has no enrolled students.</p>
    </div>
    @endif

    <div class="footer">
        <p>This document was generated electronically and is valid without signature.</p>
        <p>Student List - Section {{ $section->section_name }} - Generated by {{ $instructor->first_name }} {{ $instructor->last_name }}</p>
    </div>
</body>

</html>