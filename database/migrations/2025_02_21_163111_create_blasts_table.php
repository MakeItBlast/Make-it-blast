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
        Schema::create('blasts', function (Blueprint $table) {
            $table->id(); 
            $table->string('blast_name');
            $table->unsignedBigInteger('tempelate_id'); // Required field
            $table->unsignedBigInteger('user_id'); // Required field
            $table->text('tempelate_structure')->nullable(); // Optional field
            $table->enum('status',['active','inactive'])->default('active'); // Optional default status
            $table->timestamps();
            $table->softDeletes();
            //connection
            $table->foreign('tempelate_id')->references('id')->on('tempelates')->onDelete('cascade');
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
        Schema::dropIfExists('blasts');
    }
};
