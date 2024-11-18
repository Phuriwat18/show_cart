<!-- resources/views/admin/orders/show.blade.php -->
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดคำสั่งซื้อ #{{ $order->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1, h3 {
            color: #333;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-info, .order-items {
            margin-bottom: 30px;
        }

        .order-info p {
            font-size: 1.2em;
            line-height: 1.6;
        }

        .order-info p strong {
            color: #007bff;
        }

        .order-items ul {
            list-style-type: none;
            padding: 0;
        }

        .order-items li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .order-items li img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 20px;
            border-radius: 8px;
        }

        .order-items li .product-info {
            flex-grow: 1;
        }

        .order-items li .product-info p {
            margin: 5px 0;
        }

        .order-items li .product-info p strong {
            color: #555;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 1.2em;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>รายละเอียดคำสั่งซื้อ #{{ $order->id }}</h1>

        <div class="order-info">
            <h3>ข้อมูลลูกค้า</h3>
            <p><strong>ชื่อลูกค้า:</strong> {{ $order->user->name }}</p>
            <p><strong>สถานะการชำระเงิน:</strong> {{ $order->status == 1 ? 'ชำระเงินแล้ว' : 'ยังไม่ชำระเงิน' }}</p>
            <p><strong>ยอดรวม:</strong> {{ number_format($order->total, 2) }} บาท</p>
        </div>

        <div class="order-items">
            <h3>รายละเอียดสินค้าในคำสั่งซื้อ</h3>
            <ul>
                @foreach ($order->order_details as $detail)
                    <li>
                        <img src="{{ asset('storage/' . $detail->product->image) }}" alt="Product Image">
                        <div class="product-info">
                            <p><strong>ชื่อสินค้า:</strong> {{ $detail->product->name }}</p>
                            <p><strong>ราคา:</strong> {{ number_format($detail->price, 2) }} บาท</p>
                            <p><strong>จำนวนที่สั่งซื้อ:</strong> {{ $detail->amount }} ชิ้น</p>
                            <p><strong>ราคารวม:</strong> {{ number_format($detail->price * $detail->amount, 2) }} บาท</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <a href="{{ route('orders.report') }}" class="back-link">กลับไปหน้ารายงานการสั่งซื้อ</a>
    </div>
</body>

</html>
