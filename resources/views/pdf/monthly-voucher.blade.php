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
        {{ \Carbon\Carbon::parse($voucherLists[0]->voucher->date)->format('M-Y') }}
    </h3>
    <table class="table">
        <thead>
            <tr style="color: #f0f0f0">
                <th>Customer</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Purchase Time</th>
                <th>Date</th>
            </tr>

        <tbody>
            @foreach ($voucherLists as $vl)
                <tr>
                    <td>{{ $vl->voucher->customer_name }}</td>
                    <td>
                        {{ $vl->item_name }}
                    </td>
                    <td>{{ $vl->unit_price }}</td>
                    <td>{{ $vl->quantity }}</td>
                    <td>{{ $vl->cost }} MMK</td>
                    <td>{{ \Carbon\Carbon::parse($vl->voucher->date)->format('d-M') }}</td>
                    <td>{{ \Carbon\Carbon::parse($vl->voucher->created_at)->format('h:i a') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="font-weight: bolder;text-align: center">Today Sales</td>
                <td colspan="3" style="font-weight:bolder">{{ $total }} MMK</td>
            </tr>
        </tfoot>
        </thead>
    </table>
</body>

</html>
