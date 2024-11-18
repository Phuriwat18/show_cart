<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จการชำระเงิน</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 20px;
            color: #333;
            background-color: #f4f7fc;
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .receipt-header,
        .receipt-details {
            margin-top: 20px;
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .receipt-header h2 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }

        .receipt-header .status {
            font-weight: bold;
            font-size: 18px;
            color: #4CAF50;
        }

        .receipt-details h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }

        .receipt-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            font-size: 16px;
            color: #333;
        }

        .total {
            font-weight: 700;
            font-size: 18px;
            text-align: right;
            margin-top: 20px;
        }

        .back-button {
            text-align: center;
            margin-top: 30px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-button a:hover {
            background-color: #45a049;
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            text-align: center;
            color: #777;
        }

        .status-paid {
            color: #28a745;
        }

        .status-unpaid {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <h1>ใบเสร็จการชำระเงิน</h1>

    @foreach($orders as $order)
    <div class="receipt-header">
        <div>
            <h2>หมายเลขคำสั่งซื้อ: {{ $order->id }}</h2>
            <p>ชื่อลูกค้า: {{ $order->user->name }}</p>
            <p>วันที่ชำระเงิน: {{ $order->updated_at->setTimezone('Asia/Bangkok')->format('d/m/Y H:i') }}</p>
        </div>
        <div class="status">
            <p class="{{ $order->status == 1 ? 'status-paid' : 'status-unpaid' }}">
                {{ $order->status == 1 ? 'ชำระเงินแล้ว' : 'ยังไม่ชำระเงิน' }}
            </p>
        </div>
    </div>

    <div class="receipt-details">
        <h3>รายละเอียดสินค้า</h3>
        <table>
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>ยอดรวม</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->order_details as $detail)
                <tr>
                    <td>{{ $detail->product_name }}</td>
                    <td>{{ $detail->amount }}</td>
                    <td>{{ number_format($detail->price, 2) }} บาท</td>
                    <td>{{ number_format($detail->price * $detail->amount, 2) }} บาท</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>ยอดรวม: {{ number_format($order->total, 2) }} บาท</p>
        </div>
    </div>
    @endforeach

    
    <!-- ปุ่มกลับหน้าสินค้า -->
    <div class="back-button">
        <a href="{{ route('home') }}">กลับไปหน้าสินค้า</a>
    </div>

    <div class="footer">
        <p>ขอบคุณที่ใช้บริการ!</p>
    </div>
</body>

</html>
