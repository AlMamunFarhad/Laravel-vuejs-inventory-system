<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->string('root')->nullable();
            $table->string('buying_price')->nullable();
            $table->string('selling_price');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->date('buying_date')->nullable();
            $table->string('image')->nullable();
            $table->string('product_quantity');
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
