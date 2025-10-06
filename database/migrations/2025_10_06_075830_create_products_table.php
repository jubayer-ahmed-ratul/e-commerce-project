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
            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->float('price');
            $table->float('compare_at_price')->nullable();
            $table->float('cost_per_item')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->float('quantity');
            $table->float('security_stock')->nullable();
            $table->string('shiping')->nullable();
            $table->boolean('visibility');
            $table->string('brand')->nullable();
            $table->string('catagories')->nullable();
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
