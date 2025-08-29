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
        Schema::create('product_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->string('product_id')->nullable();
            $table->string('drink_name')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('abv')->nullable();
            $table->string('blurb')->nullable();
            $table->tinyInteger('drink_type')->comment("1 = Beer , 2 = Spirits , 3 = Wines")->nullable();
            $table->string('product_image')->nullable();
            $table->tinyInteger('status')->comment("1 = visible , 0 = not visible")->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_info');
    }
};
