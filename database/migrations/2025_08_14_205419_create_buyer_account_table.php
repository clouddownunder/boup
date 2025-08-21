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
        Schema::create('buyer_delete_accountinfo', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string("reason")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_delete_accountinfo');
    }
};
