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

        .instructor-info {
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

        .instructor-id {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 25px;
        }

        .instructor-id .id-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .instructor-id .id-value {
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
        <div class="title">Instructor Record</div>
        <div class="subtitle">{{ $instructor->first_name }} {{ $instructor->last_name }}</div>
        <div class="date">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</div>
    </div>

    <div class="instructor-id">
        <div class="id-label">Instructor ID</div>
        <div class="id-value">#{{ $instructor->id }}</div>
    </div>

    <div class="instructor-info">
        <div class="section-title">Personal Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Full Name:</div>
                <div class="info-value">{{ $instructor->first_name }} {{ $instructor->last_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email Address:</div>
                <div class="info-value">{{ $instructor->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Gender:</div>
                <div class="info-value">{{ $instructor->gender }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date of Birth:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($instructor->date_of_birth)->format('F j, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Age:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($instructor->date_of_birth)->age }} years old</div>
            </div>
            @if($instructor->contact_number)
            <div class="info-row">
                <div class="info-label">Contact Number:</div>
                <div class="info-value">{{ $instructor->contact_number }}</div>
            </div>
            @endif
        </div>

        @if($instructor->country || $instructor->province || $instructor->city || $instructor->street || $instructor->zipcode)
        <div class="section-title">Address Information</div>
        <div class="info-grid">
            @if($instructor->street)
            <div class="info-row">
                <div class="info-label">Street:</div>
                <div class="info-value">{{ $instructor->street }}</div>
            </div>
            @endif
            @if($instructor->city)
            <div class="info-row">
                <div class="info-label">City:</div>
                <div class="info-value">{{ $instructor->city }}</div>
            </div>
            @endif
            @if($instructor->province)
            <div class="info-row">
                <div class="info-label">Province:</div>
                <div class="info-value">{{ $instructor->province }}</div>
            </div>
            @endif
            @if($instructor->country)
            <div class="info-row">
                <div class="info-label">Country:</div>
                <div class="info-value">{{ $instructor->country }}</div>
            </div>
            @endif
            @if($instructor->zipcode)
            <div class="info-row">
                <div class="info-label">Zip Code:</div>
                <div class="info-value">{{ $instructor->zipcode }}</div>
            </div>
            @endif
        </div>
        @endif

        <div class="section-title">System Information</div>
        <div class="info-grid">
            @if($instructor->user_id)
            <div class="info-row">
                <div class="info-label">User ID:</div>
                <div class="info-value">{{ $instructor->user_id }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Registration Date:</div>
                <div class="info-value">{{ $instructor->created_at->format('F j, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Updated:</div>
                <div class="info-value">{{ $instructor->updated_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This document was automatically generated by the Instructor Management System.</p>
        <p>Document ID: INST-{{ $instructor->id }}-{{ now()->format('YmdHis') }}</p>
    </div>
</body>

</html>