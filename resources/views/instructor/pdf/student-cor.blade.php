<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Registration - {{ $student->first_name }} {{ $student->last_name }}</title>
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
            font-size: 18px;
            color: #666;
            margin: 0 0 5px 0;
            font-weight: normal;
        }
        
        .student-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }
        
        .student-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .student-info td {
            padding: 5px 0;
            vertical-align: top;
        }
        
        .student-info .label {
            font-weight: bold;
            width: 120px;
            color: #4f46e5;
        }
        
        .term-section {
            margin-bottom: 25px;
        }
        
        .term-header {
            background-color: #4f46e5;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .courses-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .courses-table th {
            background-color: #f1f3f4;
            padding: 10px 8px;
            border: 1px solid #ddd;
            font-weight: bold;
            text-align: left;
            font-size: 11px;
        }
        
        .courses-table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        .courses-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        .summary {
            background-color: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .summary h3 {
            color: #4f46e5;
            margin: 0 0 10px 0;
            font-size: 14px;
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
    </style>
</head>
<body>
    <div class="date-generated">
        Generated on: {{ now()->format('F d, Y - h:i A') }}
    </div>

    <div class="header">
        <h1>CERTIFICATE OF REGISTRATION</h1>
        <h2>Student Academic Record</h2>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td class="label">Student Name:</td>
                <td>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</td>
                <td class="label">Student ID:</td>
                <td>{{ $student->student_id }}</td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td>{{ $student->email }}</td>
            </tr>
            <tr>
                <td class="label">Phone:</td>
                <td>{{ $student->phone ?? 'N/A' }}</td>
                <td class="label">Address:</td>
                <td>{{ $student->address ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    @if($enrollmentsByTerm->count() > 0)
        @foreach($enrollmentsByTerm as $termName => $enrollments)
            <div class="term-section">
                <div class="term-header">
                    {{ $termName }}
                </div>
                
                <table class="courses-table">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Title</th>
                            <th>Credits</th>
                            <th>Section</th>
                            <th>Schedule</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalCredits = 0; @endphp
                        @foreach($enrollments as $enrollment)
                            @php $totalCredits += $enrollment->schedule->course->credits; @endphp
                            <tr>
                                <td>{{ $enrollment->schedule->course_code }}</td>
                                <td>{{ $enrollment->schedule->course->course_name }}</td>
                                <td style="text-align: center;">{{ $enrollment->schedule->course->credits }}</td>
                                <td>{{ $enrollment->schedule->section->section_name }}</td>
                                <td>
                                    {{ $enrollment->schedule->day }}<br>
                                    {{ date('g:i A', strtotime($enrollment->schedule->starting_time)) }} - 
                                    {{ date('g:i A', strtotime($enrollment->schedule->ending_time)) }}
                                </td>
                                <td>
                                    <span style="color: #10b981; font-weight: bold;">Enrolled</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="summary">
                    <h3>Term Summary</h3>
                    <p><strong>Total Courses:</strong> {{ $enrollments->count() }}</p>
                    <p><strong>Total Credits:</strong> {{ $totalCredits }}</p>
                </div>
            </div>
        @endforeach

        <!-- Overall Summary -->
        <div class="summary" style="background-color: #f0f9ff;">
            <h3>Overall Summary</h3>
            @php
                $grandTotalCourses = 0;
                $grandTotalCredits = 0;
                foreach($enrollmentsByTerm as $enrollments) {
                    $grandTotalCourses += $enrollments->count();
                    foreach($enrollments as $enrollment) {
                        $grandTotalCredits += $enrollment->schedule->course->credits;
                    }
                }
            @endphp
            <p><strong>Total Courses Enrolled:</strong> {{ $grandTotalCourses }}</p>
            <p><strong>Total Credits:</strong> {{ $grandTotalCredits }}</p>
            <p><strong>Terms Covered:</strong> {{ $enrollmentsByTerm->count() }}</p>
        </div>
    @else
        <div style="text-align: center; padding: 40px; color: #666;">
            <h3>No Enrollment Records Found</h3>
            <p>This student has no course enrollments in your classes.</p>
        </div>
    @endif

    <div class="footer">
        <p>This document was generated electronically and is valid without signature.</p>
        <p>Certificate of Registration - {{ $student->first_name }} {{ $student->last_name }}</p>
    </div>
</body>
</html>