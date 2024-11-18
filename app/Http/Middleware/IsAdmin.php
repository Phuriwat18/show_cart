<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // ตรวจสอบว่าผู้ใช้เข้าสู่ระบบแล้วและเป็น admin หรือไม่
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // อนุญาตให้ผ่านถ้าเป็น admin
        }

        // ถ้าไม่ใช่ admin ให้ redirect ไปที่หน้าอื่น เช่น หน้าแรก
        return redirect('home')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
    }
}
