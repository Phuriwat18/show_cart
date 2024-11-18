<!DOCTYPE html>
<html>

<head>
    <title>ใบเสร็จคำสั่งซื้อ #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
        }
        .btn-primary {
            background-color: #2575fc;
            border: none;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .text-muted {
            font-size: 1.1em;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <h2 class="mb-0">ใบเสร็จสำหรับคำสั่งซื้อ #{{ $order->id }}</h2>
            </div>
            <div class="card-body">
                <p class="text-center mb-3">
                    <strong>รหัสผู้ใช้:</strong> {{ $order->user_id }}
                </p>
                <p class="text-center mb-3">
                    <strong>สถานะ:</strong>
                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'secondary' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p class="text-center mb-3">
                    <strong>ยอดรวม:</strong> ฿{{ number_format($order->total, 2) }}
                </p>
                <p class="text-center mb-3">
                    <strong>วันที่:</strong> {{ $order->created_at->format('Y-m-d') }}
                </p>
            </div>
            <div class="card-footer text-center">
                <h4 class="text-muted">ขอบคุณที่ใช้บริการ!</h4>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">แก้ไขคำสั่งซื้อ</a>
                    <form action="{{ route('orders.update', $order->id) }}" method="post" class="d-inline-block">
                        @csrf
                        @method('put')
                        <input type="hidden" name="value" value="ชำระเงิน">
                        <button class="btn btn-primary" type="submit">ชำระเงิน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
