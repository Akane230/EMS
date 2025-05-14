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
        .description {
            max-width: 400px;
            word-wrap: break-word;
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
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Description</th>
                <th>Program</th>
                <th>Created Date</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->course_code }}</td>
                <td>{{ $course->course_name }}</td>
                <td>{{ $course->credits }}</td>
                <td class="description">{{ $course->description }}</td>
                <td>{{ $course->program ? $course->program->program_name : 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($course->created_at)->format('m/d/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($course->updated_at)->format('m/d/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>