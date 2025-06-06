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

        .term-info {
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

        .term-id {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 25px;
        }

        .term-id .id-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .term-id .id-value {
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
        <div class="title">Term Record</div>
        <div class="subtitle">{{ $term->schoolyear_semester }}</div>
        <div class="date">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</div>
    </div>

    <div class="term-id">
        <div class="id-label">Term ID</div>
        <div class="id-value">#{{ $term->id }}</div>
    </div>

    <div class="term-info">
        <div class="section-title">Term Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Term Name:</div>
                <div class="info-value">{{ $term->schoolyear_semester }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">{{ $term->status }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Start Date:</div>
                <div class="info-value">{{ $term->start_date->format('F j, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">End Date:</div>
                <div class="info-value">{{ $term->end_date->format('F j, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Duration:</div>
                <div class="info-value">{{ $term->start_date->diffInDays($term->end_date) }} days</div>
            </div>
        </div>

        <div class="section-title">System Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Created At:</div>
                <div class="info-value">{{ $term->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Updated:</div>
                <div class="info-value">{{ $term->updated_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This document was automatically generated by the Term Management System.</p>
        <p>Document ID: TERM-{{ $term->id }}-{{ now()->format('YmdHis') }}</p>
    </div>
</body>

</html>