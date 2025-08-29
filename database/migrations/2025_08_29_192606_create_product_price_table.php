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
        Schema::create('product_price', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_info_id')->nullable()->constrained('product_info')->cascadeOnDelete();
            $table->tinyInteger('container_type')->comment("1 = Bottle , 2 = Can")->nullable();
            $table->integer('quantity')->nullable();
            $table->float('volume')->nullable();
            $table->float('cost_per_sku')->nullable();
            $table->float('total_weight')->nullable();
            $table->string('name_of_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price');
    }
};
