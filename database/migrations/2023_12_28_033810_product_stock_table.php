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
        //product stock structure data table
        Schema::create('products',function (Blueprint $table){
            $table->id('product_id');
            $table->string('product_name');
            $table->text('descreiption');
            $table->float('product_rpice',8,2);
            $table->foreignId('type_id');
            $table->timestamp('product_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //dropping table products
        Schema::dropIfExists('products');
    }
};
