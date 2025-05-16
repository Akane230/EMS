<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
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
        .avatar-placeholder {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #4f46e5;
            color: white;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-admin {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .badge-instructor {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge-student {
            background-color: #d1fae5;
            color: #065f46;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .page-number {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 12px;
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
                <th>Role</th>
                <th>Last Login</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    @if($user->avatar)
                    <img src="{{ storage_path('app/public/' . $user->avatar) }}" width="30" height="30" style="border-radius: 50%; vertical-align: middle;">
                    @else
                    <div class="avatar-placeholder">{{ substr($user->name, 0, 1) }}</div>
                    @endif
                    {{ $user->name }}
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge 
                        @if($user->role == 'Admin') badge-admin
                        @elseif($user->role == 'Instructor') badge-instructor
                        @elseif($user->role == 'Student') badge-student
                        @endif">
                        {{ $user->role }}
                    </span>
                </td>
                <td>{{ $user->last_login ? $user->last_login->format('M d, Y H:i') : 'Never' }}</td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        This document contains confidential information. Please handle with care.
    </div>

    <div class="page-number">Page 1 of 1</div>
</body>
</html>