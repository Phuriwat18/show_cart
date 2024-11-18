<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    // ความสัมพันธ์กับ Product (สมมุติว่าในตาราง order_details มีคอลัมน์ product_id)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // ถ้าคีย์ต่างประเทศชื่อ 'product_id'
    }
}
