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
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="date">Generated on: {{ now()->format('F j, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Section Name</th>
                <th>Program</th>
                <th>Department</th>
                <th>Created Date</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sections as $section)
            <tr>
                <td>{{ $section->id }}</td>
                <td>{{ $section->section_name }}</td>
                <td>{{ $section->program->program_name }}</td>
                <td>{{ $section->program->department->deparment_name }}</td>
                <td>{{ \Carbon\Carbon::parse($section->created_at)->format('m/d/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($section->updated_at)->format('m/d/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>