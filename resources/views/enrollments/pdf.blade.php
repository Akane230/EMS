<!DOCTYPE html>
<html>
<head>
    <title>Enrollment Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #4f46e5;
            color: white;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .date {
            font-size: 14px;
            color: #eee;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .student-info {
            font-weight: bold;
        }
        .student-id {
            font-size: 12px;
            color: #666;
        }
        .year-level {
            display: inline-block;
            padding: 3px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 12px;
            background-color: #dbeafe;
            color: #1e40af;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            padding: 20px;
        }
        .page-number {
            text-align: right;
            padding: 10px;
            font-size: 12px;
        }
        .summary {
            margin: 20px 0;
            padding: 15px;
            background-color: #f3f4f6;
            border-radius: 5px;
        }
        .summary-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .summary-label {
            color: #666;
        }
        .summary-value {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Enrollment Records</div>
        <div class="subtitle">Complete List of Student Course Enrollments</div>
        <div class="date">Generated on: {{ now()->format('F j, Y') }}</div>
    </div>

    <div class="summary">
        <div class="summary-title">Summary</div>
        <div class="summary-row">
            <span class="summary-label">Total Enrollments:</span>
            <span class="summary-value">{{ $enrollments->count() }}</span>
        </div>
        @if(isset($termCounts) && count($termCounts) > 0)
        <div class="summary-row">
            <span class="summary-label">Enrollments by Term:</span>
            <span class="summary-value">
                @foreach($termCounts as $term => $count)
                    {{ $term }}: {{ $count }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </span>
        </div>
        @endif
        @if(isset($yearLevelCounts) && count($yearLevelCounts) > 0)
        <div class="summary-row">
            <span class="summary-label">Enrollments by Year Level:</span>
            <span class="summary-value">
                @foreach($yearLevelCounts as $yearLevel => $count)
                    Year {{ $yearLevel }}: {{ $count }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </span>
        </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Student</th>
                <th>Term</th>
                <th>Course</th>
                <th>Section</th>
                <th>Schedule</th>
                <th>Year Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
            <tr>
                <td>
                    <div class="student-info">{{ $enrollment->student->last_name ?? 'N/A' }}, {{ $enrollment->student->first_name ?? '' }}</div>
                    <div class="student-id">ID: {{ $enrollment->student->id ?? 'N/A' }}</div>
                </td>
                <td>{{ $enrollment->term->name ?? 'N/A' }}</td>
                <td>
                    <div>{{ $enrollment->course_code }}</div>
                    <div class="student-id">{{ $enrollment->course->name ?? 'N/A' }}</div>
                </td>
                <td>{{ $enrollment->section->name ?? 'N/A' }}</td>
                <td>
                    @if($enrollment->schedule)
                        {{ $enrollment->schedule->day ?? 'N/A' }}, 
                        {{ \Carbon\Carbon::parse($enrollment->schedule->starting_time ?? '')->format('h:i A') }} - 
                        {{ \Carbon\Carbon::parse($enrollment->schedule->ending_time ?? '')->format('h:i A') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <div class="year-level">Year {{ $enrollment->year_level }}</div>
                </td>
            </tr>
            @endforeach

            @if($enrollments->count() == 0)
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #666;">
                    No enrollments found.
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>This is an official report of all student enrollments in the system.</p>
        <p>For any discrepancies, please contact the registrar's office.</p>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->getFont("Arial", "bold");
            $size = 12;
            $color = array(0,0,0);
            $width = $fontMetrics->getTextWidth($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size, $color);
        }
    </script>
</body>
</html>