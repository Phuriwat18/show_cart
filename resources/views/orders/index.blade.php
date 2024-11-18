{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($order)
                            @foreach ($order->order_details as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ number_format($item->price, 2) }} บาท</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>
                                        <div class="row text-center">
                                            <!-- ปุ่มลดจำนวนสินค้า -->
                                            <div class="col-6">
                                                <form action="{{ route('orders.update', $order->id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="value" value="decrease">
                                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                    <button class="btn btn-danger btn-sm" type="submit">-</button>
                                                </form>
                                            </div>
                                            
                                            <!-- ปุ่มเพิ่มจำนวนสินค้า -->
                                            <div class="col-6">
                                                <form action="{{ route('orders.update', $order->id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="value" value="increase">
                                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                    <button class="btn btn-success btn-sm" type="submit">+</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>{{ number_format($order->total, 2) }} บาท</strong></td>
                                <td class="text-center">
                                    <!-- ปุ่ม ชำระเงิน -->
                                    <form action="{{ route('order.receipt', $order->id) }}" >
                                        @csrf
                                        <input type="hidden" name="value" value="ชำระเงิน">
                                        <button class="btn btn-primary btn-lg" type="submit">ชำระเงิน</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if ($orderDetails->count() > 0)
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ชื่อสินค้า</th>
                                <th>ราคา</th>
                                <th>จำนวน</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ number_format($item->price, 2) }} บาท</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <form action="{{ route('orders.update', $order->id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="value" value="decrease">
                                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                    <button class="btn btn-danger btn-sm" type="submit">-</button>
                                                </form>
                                            </div>
                                            
                                            <div class="col-6">
                                                <form action="{{ route('orders.update', $order->id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="value" value="increase">
                                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                    <button class="btn btn-success btn-sm" type="submit">+</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>{{ number_format($order->total, 2) }} บาท</strong></td>
                                <td class="text-center">
                                    <form action="{{ route('order.receipt', $order->id) }}">
                                        @csrf
                                        <input type="hidden" name="value" value="ชำระเงิน">
                                        <button class="btn btn-primary btn-lg" type="submit">ชำระเงิน</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- ลิงก์แบ่งหน้า -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orderDetails->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <strong>ตะกร้าของคุณว่าง!</strong> กรุณาเลือกสินค้าที่ต้องการซื้อ
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
