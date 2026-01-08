<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h3>Bank Accounts</h3>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Bank</th>
            <th>Account Number</th>
        </tr>
    </thead>
    <tbody>
        @foreach($accounts as $a)
            <tr>
                <td>{{ $a->user->first_name }} {{ $a->user->last_name }}</td>
                <td>{{ $a->user->email }}</td>
                <td>{{ $a->user->phone }}</td>
                <td>{{ $a->bank_name }}</td>
                <td>{{ $a->account_number }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
