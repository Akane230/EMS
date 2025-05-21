<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certificate of Registration</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .university { font-size: 16px; font-weight: bold; }
        .title { font-size: 14px; margin: 5px 0; }
        .cor-title { font-size: 18px; font-weight: bold; margin: 15px 0; text-decoration: underline; }
        .student-info { margin-bottom: 20px; }
        .info-row { display: flex; margin-bottom: 5px; }
        .info-label { width: 150px; font-weight: bold; }
        .info-value { flex: 1; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 30px; display: flex; justify-content: space-between; }
        .signature { width: 200px; border-top: 1px solid #000; text-align: center; margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="university">EMS UNIVERSITY NAME</div>
        <div class="title">Office of the Registrar</div>
        <div class="cor-title">CERTIFICATE OF REGISTRATION</div>
    </div>

    <div class="student-info">
        <div class="info-row">
            <div class="info-label">Student Name:</div>
            <div class="info-value">{{ $student->first_name }} {{ $student->last_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Student ID:</div>
            <div class="info-value">{{ $student->id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Program:</div>
            <div class="info-value">{{ $program->program_name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Term:</div>
            <div class="info-value">{{ $term->schoolyear_semester }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Section</th>
                <th>Schedule</th>
                <th>Room</th>
                <th>Instructor</th>
                <th>Credits</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->course->course_code }}</td>
                    <td>{{ $enrollment->course->course_name }}</td>
                    <td>{{ $enrollment->section->section_name ?? 'N/A' }}</td>
                    <td>
                        @if($enrollment->schedule)
                            {{ $enrollment->schedule->days }} 
                            {{ date('h:i A', strtotime($enrollment->schedule->start_time)) }}-{{ date('h:i A', strtotime($enrollment->schedule->end_time)) }}
                        @else
                            Not Scheduled
                        @endif
                    </td>
                    <td>{{ $enrollment->schedule->room->roomname ?? 'TBA' }}</td>
                    <td>
                        @if($enrollment->schedule && $enrollment->schedule->instructor)
                            {{ $enrollment->schedule->instructor->name }}
                        @else
                            TBA
                        @endif
                    </td>
                    <td>{{ $enrollment->course->credits }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;">Total Credits:</td>
                <td>{{ $enrollments->sum('course.credits') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>
            <div>Date Issued: {{ date('m/d/Y') }}</div>
            <div>Registrar's Office</div>
        </div>
        <div class="signature">
            Student's Signature
        </div>
    </div>
</body>
</html>