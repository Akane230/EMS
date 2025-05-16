<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            height: 60px;
        }
        .institution-info {
            text-align: center;
            margin-bottom: 15px;
        }
        .institution-name {
            font-size: 18px;
            font-weight: bold;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('images/logo.png') }}" alt="Institution Logo">
    </div>
    
    <div class="institution-info">
        <div class="institution-name">Your Institution Name</div>
        <div class="report-title">Instructor Position Assignments</div>
        <div class="date">Generated on: {{ now()->format('F j, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Instructor</th>
                <th>Email</th>
                <th>Position</th>
                <th>Department</th>
                <th>Assigned Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($instructorPositions as $assignment)
            <tr>
                <td>{{ $assignment->id }}</td>
                <td>{{ $assignment->instructor->name ?? 'N/A' }}</td>
                <td>{{ $assignment->instructor->email ?? 'N/A' }}</td>
                <td>{{ $assignment->position->title ?? 'N/A' }}</td>
                <td>{{ $assignment->position->department ?? 'N/A' }}</td>
                <td>{{ $assignment->created_at->format('m/d/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 30px; text-align: right; font-size: 12px;">
        <p>Total Records: {{ count($instructorPositions) }}</p>
        <p>Page 1 of 1</p>
    </div>
</body>
</html>