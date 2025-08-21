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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->tinyInteger('status')->comment("0 = Not Active, 1 = Active");
            $table->string('name')->nullable();
            $table->date('dob')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('business_name')->nullable();
            $table->string('abn')->nullable();
            $table->string('liquor_licence_no')->nullable();
            $table->text('street_address1')->nullable();
            $table->text('street_address2')->nullable();
            $table->string('suburb')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('region')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('notes')->nullable();
            $table->string('sign_image')->nullable();
            $table->string('website_url')->nullable();
            $table->string('business_phone_no')->nullable();
            $table->string('logo')->nullable();
            $table->string('title_image')->nullable();
            $table->text('mailing_address')->nullable();
            $table->string('mailing_suburb')->nullable();
            $table->string('mailing_state')->nullable();
            $table->string('mailing_postcode')->nullable();
            $table->string('mailing_latitude')->nullable();
            $table->string('mailing_longitude')->nullable();
            $table->text('map_address')->nullable();
            $table->string('map_suburb')->nullable();
            $table->string('map_state')->nullable();
            $table->string('map_postcode')->nullable();
            $table->string('map_latitude')->nullable();
            $table->string('map_longitude')->nullable();
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
        Schema::dropIfExists('vendors');
    }
};
