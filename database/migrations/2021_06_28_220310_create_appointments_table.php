<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('counselor_id');
            $table->text('student_reason'); // Reason why he schdule
            $table->text('student_date'); // When the student is availabile
            $table->string('request_status')->default('pending'); // student request is pending, accepted, refused
            $table->text('counselor_note')->nullable(); // counselor might accept or refuse but if he want he can also describes his suggestion
            // if the counselor accepted his request he will update his zoom metting id, metting passcode and also time and date
            $table->string('metting_id')->nullable();
            $table->string('metting_passcode')->nullable();
            $table->text('metting_time_date')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
