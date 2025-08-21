<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->text('experience')->nullable();
            $table->text('suggestion')->nullable();
            $table->dateTime('feedback_date')->nullable();
            $table->string('app_version')->nullable();
            $table->string("os_version")->nullable();
            $table->tinyInteger('device_type')->comment("0 = Web, 1 = iOS, 2 = Android");
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
        Schema::dropIfExists('feedbacks');
    }
}
