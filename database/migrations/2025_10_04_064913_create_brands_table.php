<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();                 // primary key
            $table->string('name');       // brand name
            $table->string('website')->nullable(); // optional website
            $table->boolean('visibility')->default(true); // visible or hidden
            $table->timestamps();         // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
