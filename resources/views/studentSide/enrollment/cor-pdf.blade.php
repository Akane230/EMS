<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Registration</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 18px;
            font-weight: normal;
            margin-bottom: 20px;
        }
        .student-info {
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px 10px;
            border: 1px solid #ddd;
        }
        .info-table .label {
            font-weight: bold;
            width: 30%;
            background-color: #f5f5f5;
        }
        .courses-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .courses-table th, .courses-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .courses-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            width: 200px;
            border-top: 1px solid #333;
            text-align: center;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>UNIVERSITY NAME</h1>
        <h2>Certificate of Registration</h2>
        <p>Academic Year: {{ $term->academic_year }}</p>
        <p>Term: {{ $term->name }} ({{ $term->start_date->format('m/d/Y') }} - {{ $term->end_date->format('m/d/Y') }})</p>
    </div>

    <div class="student-info">
        <table class="info-table">
            <tr>
                <td class="label">Student Name:</td>
                <td>{{ $student->last_name }}, {{ $student->first_name }}</td>
            </tr>
            <tr>
                <td class="label">Student ID:</td>
                <td>{{ $student->student_id }}</td>
            </tr>
            <tr>
                <td class="label">Program:</td>
                <td>{{ $student->program->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Year Level:</td>
                <td>{{ $enrollments->first()->year_level ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Date Issued:</td>
                <td>{{ $date }}</td>
            </tr>
        </table>
    </div>

    <table class="courses-table">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Section</th>
                <th>Units</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->course->code }}</td>
                    <td>{{ $enrollment->course->name }}</td>
                    <td>{{ $enrollment->section->name }}</td>
                    <td>{{ $enrollment->course->units ?? 3 }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Total Units:</td>
                <td style="font-weight: bold;">{{ $enrollments->sum(function($e) { return $e->course->units ?? 3; }) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Student's Signature</p>
        </div>
        <div class="signature">
            <p>Registrar's Signature</p>
        </div>
    </div>
</body>
</html>