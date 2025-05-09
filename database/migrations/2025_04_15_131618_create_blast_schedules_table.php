<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blast_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blast_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->string('time');
            $table->string('time_zone');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('blast_id')->references('id')->on('blasts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blast_schedules');
    }
};
