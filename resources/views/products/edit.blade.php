@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="mb-4">แก้ไขข้อมูลสินค้า</h3>
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อสินค้า</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{ $product->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">ราคา (บาท)</label>
                        <input id="price" class="form-control" type="number" name="price" value="{{ $product->price }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">จำนวนสินค้าในสต็อก</label>
                        <input id="quantity" class="form-control" type="number" name="quantity" value="{{ $product->quantity }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">รูปสินค้า</label>
                        <input id="image" class="form-control" type="file" name="image">
                    </div>

                    <button class="btn btn-success mt-3 w-100" type="submit">บันทึกการแก้ไข</button>
                </form>
            </div>
        </div>
    </div>
@endsection
