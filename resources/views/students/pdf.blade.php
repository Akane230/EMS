<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Generated on: {{ now()->format('F j, Y g:i A') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Contact</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('m/d/Y') }}</td>
                    <td>{{ $student->contact_number }}</td>
                    <td>
                        @if($student->street){{ $student->street }}, @endif
                        @if($student->city){{ $student->city }}, @endif
                        @if($student->province){{ $student->province }}, @endif
                        @if($student->country){{ $student->country }} @endif
                        @if($student->zipcode)({{ $student->zipcode }})@endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>