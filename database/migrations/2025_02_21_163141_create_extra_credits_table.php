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
        Schema::create('extra_credits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trx_id')->nullable(); // Foreign Key for contact type
            $table->integer('credit');
            $table->timestamps();
            $table->foreign('trx_id')->references('id')->on('payments')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_credits');
    }
};
