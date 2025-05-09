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
        Schema::create('contact_type_with_blasts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_type_id'); // Required field
            $table->unsignedBigInteger('user_id'); // Required field
            $table->unsignedBigInteger('blast_id'); // Required field
            $table->timestamps();

            //foreign key connection 
            $table->foreign('contact_type_id')->references('id')->on('contact_types')->onDelete('cascade');
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
        Schema::dropIfExists('contact_type_with_blasts');
    }
};
