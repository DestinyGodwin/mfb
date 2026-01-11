<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profit Distribution Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        p.total {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>Profit Distribution Report ({{ $year }})</h2>

<p class="total">
    Total Profit Distributed: ₦{{ number_format($totalProfit, 2) }}
</p>

<table>
    <thead>
        <tr>
            <th>Member</th>
            <th>Total Contribution</th>
            <th>Profit</th>
            <th>Distributed At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($profits as $p)
            <tr>
                <td>{{ $p->user->first_name }} {{ $p->user->last_name }}</td>
                <td>₦{{ number_format($p->total_contribution, 2) }}</td>
                <td>₦{{ number_format($p->profit_amount, 2) }}</td>
                <td>{{ optional($p->distributed_at)->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
