<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .receipt-container { width: 80%; margin: auto; }
        .header, .footer { text-align: center; margin-bottom: 20px; }
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th, .items-table td { border: 1px solid #000; padding: 10px; text-align: left; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h2>Receipt</h2>
            <p>Order ID: {{ $order->id }}</p>
            <p>Date: {{ $order->created_at->format('d-m-Y') }}</p>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->order_details as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->price, 2 }}</td>
                    <td>{{ $item->amount * $item->price, 2 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Grand Total: {{ number_format($order->total, 2) }}</p>
        </div>

        <div class="footer">
            <p>Thank you for your purchase!</p>
        </div>
    </div>
</body>
</html>
