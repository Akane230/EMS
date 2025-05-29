<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007bff;
        }

        .subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 5px;
        }

        .date {
            font-size: 14px;
            color: #888;
        }

        .enrollment-info {
            margin-top: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 8px 15px 8px 0;
            width: 150px;
            color: #555;
        }

        .info-value {
            display: table-cell;
            padding: 8px 0;
            border-bottom: 1px dotted #ddd;
        }

        .enrollment-id {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 25px;
        }

        .enrollment-id .id-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .enrollment-id .id-value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Enrollment Record</div>
        <div class="subtitle">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</div>
        <div class="date">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</div>
    </div>

    <div class="enrollment-id">
        <div class="id-label">Enrollment ID</div>
        <div class="id-value">#{{ $enrollment->id }}</div>
    </div>

    <div class="enrollment-info">
        <div class="section-title">Student Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Student Name:</div>
                <div class="info-value">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Student ID:</div>
                <div class="info-value">{{ $enrollment->student->id }}</div>
            </div>
        </div>

        <div class="section-title">Course Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Course:</div>
                <div class="info-value">{{ $enrollment->course->course_name }} ({{ $enrollment->course->course_code }})</div>
            </div>
            <div class="info-row">
                <div class="info-label">Year Level:</div>
                <div class="info-value">{{ $enrollment->year_level }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Section:</div>
                <div class="info-value">{{ $enrollment->section->section_name ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Term:</div>
                <div class="info-value">{{ $enrollment->term->term_name ?? 'N/A' }}</div>
            </div>
        </div>

        @if($enrollment->schedule)
        <div class="section-title">Schedule Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Schedule:</div>
                <div class="info-value">
                    {{ $enrollment->schedule->day }} 
                    {{ $enrollment->schedule->start_time }} - {{ $enrollment->schedule->end_time }}
                </div>
            </div>
            @if($enrollment->schedule->room)
            <div class="info-row">
                <div class="info-label">Room:</div>
                <div class="info-value">{{ $enrollment->schedule->room->room_name }}</div>
            </div>
            @endif
            @if($enrollment->schedule->instructor)
            <div class="info-row">
                <div class="info-label">Instructor:</div>
                <div class="info-value">
                    {{ $enrollment->schedule->instructor->first_name }} 
                    {{ $enrollment->schedule->instructor->last_name }}
                </div>
            </div>
            @endif
        </div>
        @endif

        <div class="section-title">System Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Created At:</div>
                <div class="info-value">{{ $enrollment->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Updated:</div>
                <div class="info-value">{{ $enrollment->updated_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This document was automatically generated by the Enrollment Management System.</p>
        <p>Document ID: ENRL-{{ $enrollment->id }}-{{ now()->format('YmdHis') }}</p>
    </div>
</body>

</html>