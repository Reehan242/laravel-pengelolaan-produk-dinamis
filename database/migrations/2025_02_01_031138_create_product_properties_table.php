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
        Schema::create('product_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Foreignkey id product
            $table->string('property_name'); // Nama Properti 
            $table->string('property_value'); // Nilai dari Properti 
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); // reference foreignkey ke field id pada products
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_properties');
    }
};
