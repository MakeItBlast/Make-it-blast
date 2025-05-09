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
        Schema::create('resource_with_blasts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resource_id'); // Required field
            $table->unsignedBigInteger('user_id'); // Required field
            $table->unsignedBigInteger('blast_id'); // Required field
            $table->timestamps();

            //foreign key connection

            $table->foreign('resource_id')->references('id')->on('user_resources')->onDelete('cascade');
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
        Schema::dropIfExists('resource_with_blasts');
    }
};
