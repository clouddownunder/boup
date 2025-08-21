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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('name')->nullable();
            $table->date('dob')->nullable();
            $table->text('mailing_address')->nullable();
            $table->string('mailing_suburb')->nullable();
            $table->string('mailing_state')->nullable();
            $table->string('mailing_postcode')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('delivery_suburb')->nullable();
            $table->string('delivery_state')->nullable();
            $table->string('delivery_postcode')->nullable();
            $table->tinyInteger('is_setup_profile')->comment("0 = Pending , 1 = Done")->nullable();
            $table->string('device_token')->nullable();
            $table->tinyInteger('device_type')->comment("0 = Web, 1 = iOS, 2 = Android");
            $table->string('app_version')->nullable();
            $table->string("os_version")->nullable();
            $table->string("device_name")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
    }
};
