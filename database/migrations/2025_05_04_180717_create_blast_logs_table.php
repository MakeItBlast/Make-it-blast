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
        Schema::create('blast_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blast_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contact_id');
            $table->enum('status',['sent','pending','scheduled'])->default('pending');
            
            //foreignkey
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('blast_id')->references('id')->on('blasts')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contact_import_data')->onDelete('cascade');

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
        Schema::dropIfExists('blast_logs');
    }
};
