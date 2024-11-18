@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">รายการสินค้า</h2>
            <p class="text-muted">เลือกซื้อสินค้าที่คุณชื่นชอบ</p>
        </div>

        <div class="row g-4">
            @foreach ($productshow as $item)
                <div class="col-md-4">
                    <form action="{{ route('orders.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->id }}">

                        <div class="card shadow-sm border-0 rounded-4 h-100">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                class="card-img-top img-fluid rounded-top-4" style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-dark">{{ $item->name }}</h5>
                                <p class="card-text text-primary fs-5">ราคา: {{ number_format($item->price, 2) }} บาท</p>

                                @if ($item->quantity > 0)
                                    <p class="text-success mb-3">สินค้าคงเหลือ: {{ $item->quantity }} ชิ้น</p>
                                    <button class="btn btn-success w-100 fw-bold py-2" type="submit">ซื้อ</button>
                                @else
                                    <p class="text-danger fw-bold">สินค้าหมดสต็อก</p>
                                    <button class="btn btn-secondary w-100 fw-bold py-2" type="button" disabled>สินค้าหมด</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="pagination-container mt-3">
            {{ $productshow->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
