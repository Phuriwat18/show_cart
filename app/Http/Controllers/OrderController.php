<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
    //  */
    // public function index()
    // {   
    //     // ดึงข้อมูลคำสั่งซื้อที่มีสถานะเป็น 0 (ตะกร้า) ของผู้ใช้งานที่เข้าสู่ระบบ (Auth::id())
    //     // ใช้คำสั่ง where เพื่อกรองตาม user_id และ status
    //     $order = Order::where('user_id', Auth::id())->where('status', 0)->first();

    //     // ส่งข้อมูลคำสั่งซื้อนั้นไปยัง view 'orders.index'
    //     // การใช้ with('order', $order) เพื่อส่งตัวแปร $order ไปยัง view
    //     return view('orders.index')->with('order', $order);
    // }

    public function index()
    {
        // ดึงข้อมูลคำสั่งซื้อที่มีสถานะเป็น 0 (ตะกร้า) ของผู้ใช้งานที่เข้าสู่ระบบ
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        // ถ้าไม่มีคำสั่งซื้อในตะกร้าให้สร้างใหม่
        if (!$order) {
            $order = new Order();
            $order->user_id = Auth::id();
            $order->status = 0;  // กำหนดสถานะเป็น 0 (ตะกร้า)
            $order->save();
        }

        $totalItemsInCart = 0;
        if ($order) {
            // รวมจำนวนสินค้าที่มีอยู่ในตะกร้า
            $totalItemsInCart = $order->order_details->sum('amount');
        }

        // ดึงข้อมูลรายละเอียดคำสั่งซื้อและแบ่งหน้า 10 รายการต่อหน้า
        $orderDetails = $order->order_details()->paginate(10);

        // คำนวณจำนวนสินค้าที่เลือกในตะกร้า
        $totalItemsInCart = $order->order_details->sum('amount'); // total amount of products in the cart

        // ส่งข้อมูลคำสั่งซื้อและรายละเอียดไปยัง view
        return view('orders.index', compact('order', 'orderDetails', 'totalItemsInCart'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     /**
    //      * ดูข้อมูลของสินค้าตาม product_id
    //      */
    //     $product = Product::find($request->product_id);

    //     /**
    //      * เช็คว่ามีการเปิดบิลแล้วหรือยัง ของuser_id
    //      */
    //     $order = Order::where('user_id', Auth::id())->where('status', 0)->first();
    //     if ($order) {
    //         /**
    //          * ถ้ามีบิลอยู่แล้วจะทำการ updete order    
    //          */
    //         $orderDetail = $order->order_details()->where('product_id', $product->id)->first();
    //         if ($orderDetail) {
    //             $amountNew = $orderDetail->amount + 1;
    //             $orderDetail->update([
    //                 'amount' => $amountNew
    //             ]);
    //         } else {
    //             $prepareCartDetail = [
    //                 'order_id' => $order->id,
    //                 'product_id' => $product->id,
    //                 'product_name' => $product->name,
    //                 'amount' => 1,
    //                 'price' => $product->price,
    //             ];
    //             $orderDetail = OrderDetail::create($prepareCartDetail);
    //         }
    //     } else {
    //         /**
    //          * ถ้ายังไม่มีการเปิดบิลให้เปิดบิลใหม่
    //          */




    //         /**
    //          * เป็นการสร้าง order ใหม่
    //          */
    //         $prepareCart = [
    //             'status' => 0,
    //             'user_id' => Auth::id()
    //         ];
    //         $order = Order::create($prepareCart);

    //         /**
    //          * การสร้างข้องมูลลง order_detail
    //          */
    //         $prepareCartDetail = [
    //             'order_id' => $order->id,
    //             'product_id' => $product->id,
    //             'product_name' => $product->name,
    //             'amount' => 1,
    //             'price' => $product->price,
    //         ];
    //         $orderDetail = OrderDetail::create($prepareCartDetail);
    //     }

    //     $totalRaw = 0;
    //     $total = $order->order_details->map(function ($orderDetail) use ($totalRaw) {
    //         // totalRaw = totalRaw +  $orderDetail->amount * $orderDetail->price;
    //         $totalRaw += $orderDetail->amount * $orderDetail->price;
    //         return $totalRaw;
    //     })->toarray();

    //     $order->update([
    //         'total' => array_sum($total)
    //     ]);


    //     return redirect()->route('home');
    // }

    public function store(Request $request)
    {
        // ดูข้อมูลของสินค้าตาม product_id
        $product = Product::find($request->product_id);

        // ตรวจสอบว่ามีสินค้าเพียงพอหรือไม่
        if ($product->quantity <= 0) {
            return redirect()->back()->with('error', 'สินค้าหมดสต็อก');
        }

        // เช็คว่ามีการเปิดบิลแล้วหรือยัง ของ user_id
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        if ($order) {
            // ถ้ามีบิลอยู่แล้วจะทำการ update order
            $orderDetail = $order->order_details()->where('product_id', $product->id)->first();

            if ($orderDetail) {
                // ถ้ามีรายการสินค้าดังกล่าวแล้ว เพิ่มจำนวนสินค้าตามที่สั่ง
                $amountNew = $orderDetail->amount + 1;

                // เช็คจำนวนสินค้าคงเหลือในสต็อก
                if ($product->quantity < $amountNew) {
                    return redirect()->back()->with('error', 'สินค้าคงเหลือไม่พอ');
                }

                // ลดจำนวนสินค้าในสต็อก
                $product->quantity -= 1;
                $product->save();

                // อัปเดตจำนวนสินค้าสำหรับรายการที่เพิ่ม
                $orderDetail->update([
                    'amount' => $amountNew
                ]);
            } else {
                // ถ้าไม่มีสินค้านี้ในรายการสั่งซื้อ ให้เพิ่มรายการใหม่
                if ($product->quantity <= 0) {
                    return redirect()->back()->with('error', 'สินค้าหมดสต็อก');
                }

                // ลดจำนวนสินค้าในสต็อก
                $product->quantity -= 1;
                $product->save();

                // เตรียมข้อมูลสำหรับการเพิ่มรายละเอียดคำสั่งซื้อ
                $prepareCartDetail = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $product->quantity,
                    'amount' => 1,
                    'price' => $product->price,
                ];
                $orderDetail = OrderDetail::create($prepareCartDetail);
            }
        } else {
            // ถ้ายังไม่มีการเปิดบิลให้เปิดบิลใหม่
            $prepareCart = [
                'status' => 0, // สถานะสำหรับบิลที่ยังไม่ได้ชำระ
                'user_id' => Auth::id()
            ];
            $order = Order::create($prepareCart);

            // ตรวจสอบจำนวนสินค้าคงเหลือในสต็อก
            if ($product->quantity <= 0) {
                return redirect()->back()->with('error', 'สินค้าหมดสต็อก');
            }

            // ลดจำนวนสินค้าในสต็อก
            $product->quantity -= 1;
            $product->save();

            // สร้างข้อมูลใน order_detail
            $prepareCartDetail = [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $product->quantity,
                'amount' => 1,
                'price' => $product->price,
            ];
            $orderDetail = OrderDetail::create($prepareCartDetail);
        }

        // คำนวณยอดรวมของคำสั่งซื้อ
        $totalRaw = 0;
        $total = $order->order_details->map(function ($orderDetail) use ($totalRaw) {
            $totalRaw += $orderDetail->amount * $orderDetail->price;
            return $totalRaw;
        })->toArray();

        // อัปเดตยอดรวมในออเดอร์
        $order->update([
            'total' => array_sum($total)
        ]);

        // กลับไปยังหน้าเดิมพร้อมข้อความสำเร็จ
        return redirect()->route('home')->with('success', 'ทำการสั่งซื้อเรียบร้อย');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // ดึงคำสั่งซื้อพร้อมข้อมูลผู้ใช้
        $order = Order::with('user')->find($id);
        $order = Order::with(['user', 'order_details.product'])->findOrFail($id);

        // ถ้าไม่พบคำสั่งซื้อ
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'ไม่พบคำสั่งซื้อ');
        }

        // ส่งข้อมูลไปยัง view
        return view('orders.show', compact('order'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Order $order)
    // {
    //     $orderDetail = $order->order_details()->where('product_id', $request->product_id)->first();

    //     if ($request->value == "checkout") {
    //         $order->update([
    //             'status' => 1
    //         ]);
    //     } else {
    //         if ($orderDetail) {
    //             if ($request->value == "increase") {
    //                 // เพิ่มจำนวนสินค้าขึ้น 1
    //                 $amountNew = $orderDetail->amount + 1;
    //                 $orderDetail->update(['amount' => $amountNew]);
    //             } else {
    //                 // ลดจำนวนสินค้าลง 1 หรือ ลบถ้าเหลือ 1
    //                 if ($orderDetail->amount <= 1) {
    //                     $orderDetail->delete();
    //                 } else {
    //                     $amountNew = $orderDetail->amount - 1;
    //                     $orderDetail->update(['amount' => $amountNew]);
    //                 }
    //             }
    //         }
    //     }

    //     // คำนวณยอดรวม
    //     $totalRaw = 0;
    //     foreach ($order->order_details as $orderDetail) {
    //         $totalRaw += $orderDetail->amount * $orderDetail->price;
    //     }

    //     // อัปเดตยอดรวม
    //     $order->update([
    //         'total' => $totalRaw
    //     ]);

    //     return redirect()->route('orders.index');
    // }

    public function update(Request $request, Order $order)
    {
        $orderDetail = $order->order_details()->where('product_id', $request->product_id)->first();
        $product = Product::find($request->product_id);

        if ($request->value == "ชำระเงิน") {
            // อัปเดตสถานะคำสั่งซื้อเป็น "completed"
            $order->update([
                'status' => 1 // 1 หมายถึงคำสั่งซื้อชำระเงินแล้ว
            ]);

            // คำนวณยอดรวมใหม่
            $totalRaw = 0;
            foreach ($order->order_details as $orderDetail) {
                $totalRaw += $orderDetail->amount * $orderDetail->price;
            }

            // อัปเดตยอดรวม
            $order->update([
                'total' => $totalRaw
            ]);

            // รีไดเรกต์ไปยังหน้าใบเสร็จ
            return redirect()->route('orders.bil', ['orderId' => $order->id]);
        } else {
            if ($orderDetail) {
                if ($request->value == "increase") {
                    // เพิ่มจำนวนสินค้าขึ้น 1
                    $amountNew = $orderDetail->amount + 1;
                    $orderDetail->update(['amount' => $amountNew]);

                    if ($product->quantity <= 0) {
                        return redirect()->back()->with('error', 'สินค้าหมดสต็อก');
                    }

                    // ลดจำนวนสินค้าในสต็อก
                    $product->quantity -= 1;
                    $product->save();
                } else {
                    // ลดจำนวนสินค้าลง 1 หรือ ลบถ้าเหลือ 1
                    if ($orderDetail->amount <= 0) {
                        $orderDetail->delete();
                    } else {
                        // ลดจำนวนสินค้าลง 1
                        $amountNew = $orderDetail->amount - 1;
                        $orderDetail->update(['amount' => $amountNew]);

                        // ตรวจสอบว่ามีสินค้าคงเหลือหรือไม่
                        if ($product->quantity <= 0) {
                            return redirect()->back()->with('error', 'สินค้าหมดสต็อก');
                        }

                        // ลดจำนวนสินค้าในสต็อก
                        $product->quantity += 1;
                        $product->save();
                    }
                }
            }
        }

        // คำนวณยอดรวมใหม่
        $totalRaw = 0;
        foreach ($order->order_details as $orderDetail) {
            $totalRaw += $orderDetail->amount * $orderDetail->price;
        }

        // อัปเดตยอดรวม
        $order->update([
            'total' => $totalRaw
        ]);

        return redirect()->route('orders.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }



    public function showReceipt($id)
    {
        // ดึงข้อมูลคำสั่งซื้อที่มี id ตรงกับที่ส่งมา
        $order = Order::findOrFail($id);
        // ส่งข้อมูลคำสั่งซื้อไปยัง view 'orders.receipt'
        return view('orders.receipt', compact('order'));
    }

    public function report()
    {
        // ดึงข้อมูลคำสั่งซื้อทั้งหมดพร้อมข้อมูล order details และสินค้า
        $orders = Order::with(['user', 'order_details.product'])->get();
        // ดึงคำสั่งซื้อทั้งหมดพร้อมกับข้อมูลของผู้ใช้และรายละเอียดคำสั่งซื้อ
        $orders = Order::with(['user', 'order_details'])->paginate(10); // ทำการแบ่งหน้า ข้อมูลละ 10 รายการต่อหน้า

        // ส่งข้อมูลไปที่ view เพื่อแสดงรายงาน
        return view('orders.report', compact('orders'));
    }

    // ฟังก์ชันสำหรับแสดงใบเสร็จ
    public function showBil($orderId)
    {
        // ดึงคำสั่งซื้อพร้อมรายละเอียดสินค้า
        $order = Order::with('order_details')->findOrFail($orderId);

        // ส่งข้อมูลไปที่ view 'bil'
        return view('orders.bil', ['orders' => [$order]]);
    }

    public function updateBil(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // ตรวจสอบค่าของ 'status' ใน Request
        $status = $request->input('status');

        if ($status === null) {
            // ถ้าค่า status เป็น null ให้ตั้งค่า default (เช่น 0 หรือ 1 ขึ้นอยู่กับกรณี)
            $status = 0; // ตัวอย่างกำหนดให้เป็น 0 (ยังไม่ชำระเงิน)
        }

        // อัปเดตสถานะการชำระเงิน
        $order->status = $status;
        $order->save();

        // หลังจากอัปเดตสถานะแล้ว ให้ redirect ไปที่หน้าที่แสดงใบสั่งซื้อ (หรือบิล)
        return redirect()->route('orders.bil', ['orderId' => $orderId]);
    }

//     public function showdetails($id)
// {
//     // ดึงข้อมูลคำสั่งซื้อพร้อมรายละเอียดสินค้า
//     $order = Order::with(['user', 'order_details.product'])->findOrFail($id);

//     return view('orders.showdetails', compact('order'));
// }
}
