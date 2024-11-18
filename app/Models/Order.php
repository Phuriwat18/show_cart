<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // ฟังก์ชันสำหรับความสัมพันธ์ belongsTo กับ User
    public function user()
    {
        
        return $this->belongsTo(User::class, 'user_id'); // เชื่อมโยงกับโมเดล User
    }

    

}
