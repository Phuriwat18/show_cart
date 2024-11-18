<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartItemsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // คำนวณจำนวนสินค้าทั้งหมดในตะกร้า
        $totalItemsInCart = 0;
        if (Auth::check()) {
            $order = Order::where('user_id', Auth::id())->where('status', 0)->first();
            if ($order) {
                $totalItemsInCart = $order->order_details->sum('amount');
            }
        }

        // ส่งตัวแปรไปยังทุก View
        view()->share('totalItemsInCart', $totalItemsInCart);

        return $next($request);
    }
}
