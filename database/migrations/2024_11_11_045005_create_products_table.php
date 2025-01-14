<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('products', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('image')->nullable();
    //         $table->decimal('price',8,2)->default(0);
    //         $table->string('user_id');
    //         // $table->string('qty');
    //         $table->timestamps();
    //     });
    // }

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('user_id');
            $table->integer('quantity')->default(0); // เพิ่มฟิลด์ quantity สำหรับสต็อกสินค้า
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
