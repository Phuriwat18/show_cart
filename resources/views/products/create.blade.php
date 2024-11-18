@extends('layouts.app')

@section('content') 
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="mb-4">สร้างสินค้าใหม่</h3>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อสินค้า</label>
                        <input id="name" class="form-control" type="text" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">ราคา (บาท)</label>
                        <input id="price" class="form-control" type="number" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">จำนวนสินค้าในสต็อก</label>
                        <input id="quantity" class="form-control" type="number" name="quantity" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">รูปภาพสินค้า</label>
                        <input id="image" class="form-control" type="file" name="image">
                    </div>

                    <button class="btn btn-success w-100" type="submit">สร้างสินค้า</button>
                </form>
            </div>
        </div>
    </div>
@endsection


