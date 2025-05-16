<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .date {
            font-size: 14px;
            color: #666;
        }
        .day-header {
            background-color: #f2f2f2;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .page-break {
            page-break-before: always;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .small-text {
            font-size: 12px;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="date">Generated on: {{ now()->format('F j, Y') }}</div>
    </div>

    @if($groupedSchedules->isEmpty())
    <div class="no-records">
        No schedule records found.
    </div>
    @else
        @foreach($groupedSchedules as $day => $schedules)
        <div class="day-header">{{ $day }}</div>
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Instructor</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($schedule->starting_time)->format('h:i A') }} - 
                        {{ \Carbon\Carbon::parse($schedule->ending_time)->format('h:i A') }}
                    </td>
                    <td>
                        <strong>{{ $schedule->course_code }}</strong><br>
                        <span class="small-text">{{ $schedule->course->name ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $schedule->section->name ?? 'N/A' }}</td>
                    <td>{{ $schedule->instructor->first_name ?? 'N/A' }} {{ $schedule->instructor->last_name ?? '' }}</td>
                    <td>{{ $schedule->room->name ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if(!$loop->last)
            @if($loop->iteration % 2 == 0)
            <div class="page-break"></div>
            @endif
        @endif
        @endforeach
    @endif

    <div class="footer">
        © {{ now()->format('Y') }} - Schedule Management System - Page <span class="page-number"></span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Arial");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>