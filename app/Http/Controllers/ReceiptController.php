<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Model ของคำสั่งซื้อ

class ReceiptController extends Controller
{
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id); // ดึงข้อมูล Order พร้อมรายการสินค้า
        return view('receipt', compact('order'));
    }
}

