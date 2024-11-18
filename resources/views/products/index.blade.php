@extends('layouts.admin')

@section('con')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary mb-3" href="{{ route('products.create') }}">สร้างสินค้า</a>
                <div class="row g-4">
                    @foreach ($productsView as $item)
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 h-100">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="card-img-top img-fluid rounded" style="height: 200px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">{{ $item->name }}</h5>
                                    <p class="card-text text-primary fs-5">ราคา: {{ number_format($item->price, 2) }} บาท</p>
                                    
                                    <!-- Check if the item is in stock -->
                                    @if($item->quantity > 0)
                                        <p class="text-success">สินค้าคงเหลือ: {{ $item->quantity }} ชิ้น</p>
                                    @else
                                        <p class="text-danger fw-bold">สินค้าหมดสต็อก</p>
                                    @endif
                                    
                                    {{-- <form action="{{ route('orders.store') }}" method="post" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <button class="btn btn-outline-secondary w-100" type="submit" {{ $item->quantity <= 0 ? 'disabled' : '' }}>ซื้อ</button>
                                    </form> --}}
                                </div>
                                <div class="card-footer text-center">
                                    <a class="btn btn-warning w-100 mb-2" href="{{ route('products.edit', $item->id) }}">แก้ไข</a>
                                    <form action="{{ route('products.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger w-100">ลบ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="pagination-container mt-3">
                        {{ $productsView->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
