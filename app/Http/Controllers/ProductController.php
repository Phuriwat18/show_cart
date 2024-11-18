<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $products = Product::paginate(10);
        return view('products.index')->with('productsView', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // เก็บไฟล์ภาพที่ผู้ใช้อัปโหลดและจัดเก็บในโฟลเดอร์ 'images' บน disk 'public'
        $file = Storage::disk('public')->put('images', $request->image);
        // เตรียมข้อมูลที่จะเก็บในฐานข้อมูล เช่น ชื่อสินค้า, ราคา, user_id, รูปภาพ, และจำนวน
        $preparProduct = [
            'name' => $request->name,
            'price' => $request->price,
            'user_id' => Auth::id(),
            'image' => $file,
            'quantity' => $request->quantity
        ];
        // สร้างสินค้าใหม่ในฐานข้อมูลโดยใช้ข้อมูลที่เตรียมไว้
        $product = Product::create($preparProduct);

        // รีไดเรคไปยังหน้ารายการสินค้าหลังจากสร้างสินค้าสำเร็จ
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $productshow = Product::all();
        $productshow = Product::paginate(10);
        return view('products.show')->with('productshow', $productshow);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        // เตรียมข้อมูลสำหรับการอัปเดตสินค้า
        $preparProduct = [
            'name' => $request->name, // ชื่อสินค้าที่รับมาจากฟอร์ม
            'price' => $request->price, // ราคาสินค้าที่รับมาจากฟอร์ม
            'user_id' => Auth::id(), // ใช้ ID ของผู้ใช้งานที่ล็อกอินเพื่อระบุว่าเป็นเจ้าของสินค้า
            'quantity' => $request->quantity // จำนวนสินค้าที่รับมาจากฟอร์ม

        ];

        // ตรวจสอบว่าไฟล์รูปภาพถูกอัปโหลดมาหรือไม่
        if ($request->image) {
            // ถ้ามีการอัปโหลดรูปภาพ ให้เก็บไฟล์ในที่จัดเก็บสาธารณะ (public) และเก็บชื่อไฟล์ในตัวแปร $file
            $file = Storage::disk('public')->put('images', $request->image);
            // เพิ่มชื่อไฟล์ที่อัปโหลดเข้าไปในข้อมูลของสินค้า
            $preparProduct['image'] = $file;
        }

        // ค้นหาสินค้าที่ต้องการอัปเดตจากฐานข้อมูลโดยใช้ id ของสินค้า
        $productInst = Product::find($product->id);

        // ตรวจสอบว่ามีการเปลี่ยนแปลงรูปภาพหรือไม่ และหากสินค้าตัวเดิมมีรูปภาพ
        if ($productInst->image && $request->image) {
            // ถ้ามีรูปภาพเก่าอยู่ และมีการอัปโหลดรูปภาพใหม่ ให้ลบไฟล์รูปภาพเก่าออกจากที่จัดเก็บ
            unlink('storage/' . $productInst->image);
        }
        // ทำการอัปเดตข้อมูลของสินค้าในฐานข้อมูล
        $productInst->update($preparProduct);

        // รีไดเรคไปยังหน้ารายการสินค้าหลังจากการอัปเดตสำเร็จ
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // ค้นหาสินค้าตาม ID ที่ได้รับจากพารามิเตอร์
        $productInst = Product::find($product->id);

        // ตรวจสอบว่ามีรูปภาพของสินค้าหรือไม่
        if ($productInst->image) {
            // หากมีรูปภาพ ให้ทำการลบไฟล์รูปภาพจากที่เก็บใน 'storage'
            unlink('storage/' . $productInst->image);
        }

        // ลบสินค้าจากฐานข้อมูล
        $productInst->delete();

        // รีไดเรคไปยังหน้ารายการสินค้าอีกครั้งหลังจากที่ลบสินค้าสำเร็จ
        return redirect()->route('products.index');
    }
}
