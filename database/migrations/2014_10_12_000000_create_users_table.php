<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->tinyInteger('user_type')->comment("1 = Buyer, 2 = Vendor ")->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->tinyInteger('gender')->comment("1 = Male , 2 = Female")->nullable();
            $table->string("profile_pic")->nullable();
            $table->string("profile_pic_thumb")->nullable();
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
