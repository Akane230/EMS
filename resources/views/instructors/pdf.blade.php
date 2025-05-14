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
        .gender-Male {
            color: blue;
        }
        .gender-Female {
            color: purple;
        }
        .gender-Other {
            color: green;
        }
        .address {
            max-width: 200px;
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
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Contact Number</th>
                <th>Address</th>
                <th>Created Date</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($instructors as $instructor)
            <tr>
                <td>{{ $instructor->id }}</td>
                <td>{{ $instructor->first_name }} {{ $instructor->last_name }}</td>
                <td>{{ $instructor->email }}</td>
                <td class="gender-{{ $instructor->gender }}">{{ $instructor->gender }}</td>
                <td>{{ \Carbon\Carbon::parse($instructor->date_of_birth)->format('m/d/Y') }}</td>
                <td>{{ $instructor->contact_number ?? 'N/A' }}</td>
                <td class="address">
                    @if($instructor->street || $instructor->city || $instructor->province || $instructor->country)
                        {{ $instructor->street ?? '' }}<br>
                        {{ $instructor->city ?? '' }}{{ $instructor->city && $instructor->province ? ', ' : '' }}{{ $instructor->province ?? '' }}<br>
                        {{ $instructor->zipcode ?? '' }}<br>
                        {{ $instructor->country ?? '' }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($instructor->created_at)->format('m/d/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($instructor->updated_at)->format('m/d/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>