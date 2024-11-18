<!-- resources/views/admin/orders/report.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการสั่งซื้อของลูกค้า</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
            background-color: #f7faff;
            line-height: 1.6;
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            font-size: 26px;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
        }

        td {
            font-size: 14px;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #eef6e6;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            margin-bottom: 8px;
            font-size: 14px;
        }

        .status-paid {
            color: #28a745;
            font-weight: bold;
        }

        .status-unpaid {
            color: #dc3545;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
        }

        .date {
            font-style: italic;
            color: #777;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination-container .pagination {
            display: flex;
            gap: 5px;
        }

        .pagination-container .pagination li {
            list-style: none;
        }

        .pagination-container .pagination a,
        .pagination-container .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #4CAF50;
            text-decoration: none;
            transition: all 0.3s;
        }

        .pagination-container .pagination a:hover {
            background-color: #4CAF50;
            color: #fff;
        }

        .pagination-container .pagination .active {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            pointer-events: none;
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .back-button a:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>รายงานการสั่งซื้อของลูกค้า</h1>

    <table>
        <thead>
            <tr>
                <th>หมายเลขคำสั่งซื้อ</th>
                <th>ชื่อลูกค้า</th>
                <th>สถานะ</th>
                <th>ยอดรวม</th>
                <th>รายละเอียดสินค้า</th>
                <th>วันที่สั่งซื้อ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>
                        <!-- เพิ่มลิงก์เพื่อไปยังหน้ารายละเอียดคำสั่งซื้อ -->
                        <a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}.)(รายละเอียดคำสั่งซื้อ)</a>
                    </td>
                    {{-- <td>{{ $order->id }}</td> --}}
                    <td>{{ $order->user->name }}</td>
                    <td class="{{ $order->status == 1 ? 'status-paid' : 'status-unpaid' }}">
                        {{ $order->status == 1 ? 'ชำระเงินแล้ว' : 'ยังไม่ชำระเงิน' }}
                    </td>
                    <td class="total">{{ number_format($order->total, 2) }} บาท</td>
                    <td>
                        <ul>
                            @foreach ($order->order_details as $detail)
                                <li>
                                    {{ $detail->product_name }} - จำนวน: {{ $detail->amount }} - ราคา:
                                    {{ number_format($detail->price, 2) }} บาท
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="date">{{ $order->created_at->setTimezone('Asia/Bangkok')->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ลิงก์สำหรับแบ่งหน้า -->
<div class="pagination-container">
    {{ $orders->onEachSide(1)->links('pagination::bootstrap-4') }}
</div>

    <!-- ปุ่มกลับหน้าสินค้า -->
    <div class="back-button">
        <a href="{{ route('products.index') }}">กลับไปหน้าสินค้า</a>
    </div>
</body>

</html>
