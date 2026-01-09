<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contributions Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        .summary { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Contributions Report</h2>

    <div class="summary">
        <p><strong>Period:</strong> {{ $from ?? 'Beginning' }} → {{ $to ?? 'Today' }}</p>
        <p><strong>Members:</strong> {{ $selectedMembers }}</p>
        <p><strong>Total Amount:</strong> ₦{{ number_format($totalAmount, 2) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Member</th>
                <th>Amount</th>
                <th>Recorded By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contributions as $c)
                <tr>
                    <td>{{ $c->contribution_date->format('Y-m-d') }}</td>
                    <td>{{ $c->member->first_name }} {{ $c->member->last_name }}</td>
                    <td>₦{{ number_format($c->amount, 2) }}</td>
                    <td>{{ $c->recorder?->first_name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
