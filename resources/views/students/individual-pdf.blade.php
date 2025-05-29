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

        .student-info {
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

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-suspended {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-irregular {
            background-color: #e2e3e5;
            color: #383d41;
            border: 1px solid #d6d8db;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .student-id {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 25px;
        }

        .student-id .id-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .student-id .id-value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Student Record</div>
        <div class="subtitle">{{ $student->first_name }} {{ $student->last_name }}</div>
        <div class="date">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</div>
    </div>

    <div class="student-id">
        <div class="id-label">Student ID</div>
        <div class="id-value">#{{ $student->id }}</div>
    </div>

    <div class="student-info">
        <div class="section-title">Personal Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Full Name:</div>
                <div class="info-value">{{ $student->first_name }} {{ $student->last_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email Address:</div>
                <div class="info-value">{{ $student->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Gender:</div>
                <div class="info-value">{{ $student->gender }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date of Birth:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('F j, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Age:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($student->date_of_birth)->age }} years old</div>
            </div>
            @if($student->contact_number)
            <div class="info-row">
                <div class="info-label">Contact Number:</div>
                <div class="info-value">{{ $student->contact_number }}</div>
            </div>
            @endif
        </div>

        @if($student->country || $student->province || $student->city || $student->street || $student->zipcode)
        <div class="section-title">Address Information</div>
        <div class="info-grid">
            @if($student->street)
            <div class="info-row">
                <div class="info-label">Street:</div>
                <div class="info-value">{{ $student->street }}</div>
            </div>
            @endif
            @if($student->city)
            <div class="info-row">
                <div class="info-label">City:</div>
                <div class="info-value">{{ $student->city }}</div>
            </div>
            @endif
            @if($student->province)
            <div class="info-row">
                <div class="info-label">Province:</div>
                <div class="info-value">{{ $student->province }}</div>
            </div>
            @endif
            @if($student->country)
            <div class="info-row">
                <div class="info-label">Country:</div>
                <div class="info-value">{{ $student->country }}</div>
            </div>
            @endif
            @if($student->zipcode)
            <div class="info-row">
                <div class="info-label">Zip Code:</div>
                <div class="info-value">{{ $student->zipcode }}</div>
            </div>
            @endif
        </div>
        @endif

        <div class="section-title">Academic Information</div>
        <div class="info-grid">
            @if($student->user_id)
            <div class="info-row">
                <div class="info-label">User ID:</div>
                <div class="info-value">{{ $student->user_id }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ strtolower($student->status) }}">
                        {{ $student->status }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Registration Date:</div>
                <div class="info-value">{{ $student->created_at->format('F j, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Updated:</div>
                <div class="info-value">{{ $student->updated_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This document was automatically generated by the Student Management System.</p>
        <p>Document ID: STU-{{ $student->id }}-{{ now()->format('YmdHis') }}</p>
    </div>
</body>

</html>