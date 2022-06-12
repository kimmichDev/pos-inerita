<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            font-family: sans-serif;
        }

        table {

            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #c9dfff;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #448efe;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center">Vouchers for
        {{ \Carbon\Carbon::parse($dailyVouchers[0]->date)->format('d-M-Y') }}
    </h3>
    <table class="table table-hover">
        <thead>
            <tr style="color: #f0f0f0">
                <th>Voucher Number</th>
                <th>Customer Name</th>
                <th>Total</th>
                <th>Purchase Time</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailyVouchers as $dv)
                <tr>
                    <td>{{ $dv->voucher_number }}</td>
                    <td>{{ $dv->customer_name }}</td>
                    <td>{{ $dv->total }}</td>
                    <td>{{ $dv->created_at_time }}</td>
                    <td>{{ \Carbon\Carbon::parse($dv->date)->format('d-M') }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
