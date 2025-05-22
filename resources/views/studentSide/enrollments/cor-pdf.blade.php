<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        
        .school-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .school-address {
            font-size: 12px;
            margin-bottom: 15px;
        }
        
        .document-title {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 15px;
        }
        
        .student-info {
            margin: 20px 0;
            border: 1px solid #000;
            padding: 15px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .info-label {
            display: table-cell;
            width: 25%;
            font-weight: bold;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            width: 75%;
            border-bottom: 1px solid #000;
            padding-left: 10px;
        }
        
        .courses-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .courses-table th,
        .courses-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        .courses-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .course-code {
            font-weight: bold;
        }
        
        .ge-course {
            background-color: #f9f9f9;
        }
        
        .ge-badge {
            font-size: 10px;
            background-color: #e6f3ff;
            padding: 2px 4px;
            border-radius: 3px;
            margin-left: 5px;
        }
        
        .summary {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-units {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .signatures {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        
        .signature-block {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin: 30px auto 5px auto;
        }
        
        .signature-title {
            font-weight: bold;
            margin-top: 5px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 72px;
            color: rgba(200, 200, 200, 0.3);
            z-index: -1;
            font-weight: bold;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .status-enrolled {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .qr-code {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 80px;
            height: 80px;
            border: 1px solid #ccc;
        }
        
        .verification-info {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f8f9fa;
        }
        
        .semester-info {
            background-color: #e6f3ff;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Optional Watermark -->
    <div class="watermark">OFFICIAL</div>
    
    <!-- QR Code for verification (placeholder) -->
    <div class="qr-code no-print">
        <div style="display: flex; align-items: center; justify-content: center; height: 100%; font-size: 8px; text-align: center;">
            QR CODE<br>FOR<br>VERIFICATION
        </div>
    </div>
    
    <!-- Header -->
    <div class="header">
        <div class="school-name">YOUR UNIVERSITY NAME</div>
        <div class="school-address">
            University Address, City, Province<br>
            Tel: (000) 000-0000 | Email: registrar@university.edu
        </div>
        <div class="document-title">CERTIFICATE OF REGISTRATION</div>
        <div class="semester-info">
            <strong>{{ $term->schoolyear_semester }}</strong>
            <span class="status-badge status-enrolled">ENROLLED</span>
        </div>
    </div>
    
    <!-- Student Information -->
    <div class="student-info">
        <div class="info-row">
            <div class="info-label">Student Name:</div>
            <div class="info-value">{{ strtoupper($student->last_name) }}, {{ strtoupper($student->first_name) }}</div>
        </div>
            
        <div class="info-row">
            <div class="info-label">Student ID:</div>
            <div class="info-value">{{ $student->id ?? 'N/A' }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Program:</div>
            <div class="info-value">{{ $program ? $program->program_name : 'N/A' }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Year Level:</div>
            <div class="info-value">{{ $enrollments->first()->year_level }}{{ $enrollments->first()->year_level == 1 ? 'st' : ($enrollments->first()->year_level == 2 ? 'nd' : ($enrollments->first()->year_level == 3 ? 'rd' : 'th')) }} Year</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Section:</div>
            <div class="info-value">{{ $enrollments->first()->section->section_name ?? 'N/A' }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Term:</div>
            <div class="info-value">{{ $term->schoolyear_semester }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Date Enrolled:</div>
            <div class="info-value">{{ $enrollments->first()->created_at->format('F j, Y') }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">OFFICIALLY ENROLLED</div>
        </div>
    </div>
    
    <!-- Courses Table -->
    <table class="courses-table">
        <thead>
            <tr>
                <th style="width: 15%;">Course Code</th>
                <th style="width: 35%;">Course Title</th>
                <th style="width: 8%;">Units</th>
                <th style="width: 12%;">Day</th>
                <th style="width: 15%;">Time</th>
                <th style="width: 10%;">Room</th>
                <th style="width: 15%;">Instructor</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalCourses = 0;
                $majorCourses = 0;
                $geCourses = 0;
            @endphp
            
            @foreach($enrollments->sortBy('course.course_code') as $enrollment)
                @php
                    $totalCourses++;
                    if($enrollment->course->program->program_name === 'General Education') {
                        $geCourses++;
                    } else {
                        $majorCourses++;
                    }
                @endphp
                <tr class="{{ $enrollment->course->program->program_name === 'General Education' ? 'ge-course' : '' }}">
                    <td class="course-code">
                        {{ $enrollment->course->course_code }}
                        @if($enrollment->course->program->program_name === 'General Education')
                            <span class="ge-badge">GE</span>
                        @endif
                    </td>
                    <td>{{ $enrollment->course->course_name }}</td>
                    <td style="text-align: center;">{{ $enrollment->course->credits }}</td>
                    <td style="text-align: center;">
                        {{ $enrollment->schedule ? $enrollment->schedule->day : 'TBA' }}
                    </td>
                    <td style="text-align: center;">
                        @if($enrollment->schedule)
                            {{ date('g:i A', strtotime($enrollment->schedule->starting_time)) }}<br>
                            {{ date('g:i A', strtotime($enrollment->schedule->ending_time)) }}
                        @else
                            TBA
                        @endif
                    </td>
                    <td style="text-align: center;">
                        {{ $enrollment->schedule && $enrollment->schedule->room ? $enrollment->schedule->room->roomname : 'TBA' }}
                    </td>
                    <td>
                        @if($enrollment->schedule && $enrollment->schedule->instructor)
                            {{ $enrollment->schedule->instructor->first_name }} {{ $enrollment->schedule->instructor->last_name }}
                        @else
                            TBA
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Summary -->
    <div class="summary">
        <div>Total Number of Courses: <strong>{{ $totalCourses }}</strong></div>
        <div>Major Courses: <strong>{{ $majorCourses }}</strong> | General Education: <strong>{{ $geCourses }}</strong></div>
        <div class="total-units">Total Units: <strong>{{ $totalUnits }}</strong></div>
    </div>
    
    <!-- Legend -->
    @if($geCourses > 0)
        <div style="margin-top: 20px; font-size: 10px;">
            <strong>Legend:</strong> GE = General Education Course
        </div>
    @endif
    
    <!-- Academic Policies Note -->
    <div style="margin-top: 15px; font-size: 10px; border: 1px solid #ddd; padding: 8px; background-color: #f8f9fa;">
        <strong>Important Notes:</strong>
        <ul style="margin: 5px 0; padding-left: 15px;">
            <li>This certificate is valid for the academic term specified above.</li>
            <li>Any changes to enrollment must be processed through the Office of the Registrar.</li>
            <li>Students are required to maintain the minimum units for their year level.</li>
            <li>Course schedules are subject to change as announced by the university.</li>
        </ul>
    </div>
    
    <!-- Verification Info -->
    <div class="verification-info">
        <strong>Document Verification:</strong><br>
        This document can be verified online at: www.university.edu/verify<br>
        Verification Code: COR-{{ $student->id }}-{{ $term->id }}-{{ date('Ymd') }}<br>
        Generated on: {{ now()->format('F j, Y \a\t g:i A') }}
    </div>
    
    <!-- Signatures -->
    <div class="signatures">
        <div class="signature-block">
            <div class="signature-line"></div>
            <div class="signature-title">Student Signature</div>
            <div>Date: _________________</div>
        </div>
        
        <div class="signature-block">
            <div class="signature-line"></div>
            <div class="signature-title">Registrar</div>
            <div>{{ now()->format('F j, Y') }}</div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <div><strong>This is an official document. Any alterations will invalidate this certificate.</strong></div>
        <div>Certificate of Registration | Office of the Registrar | {{ now()->format('F j, Y') }}</div>
        <div style="margin-top: 5px;">
            For questions or concerns, contact the Office of the Registrar at registrar@university.edu
        </div>
    </div>
</body>
</html> 