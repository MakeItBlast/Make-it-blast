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
        Schema::create('card_details', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id');
            $table->string('f_name');
            $table->string('l_name');
            $table->string('card_number');
            $table->string('cvv');
            $table->string('exp_date');
            $table->string('country')->nullable();
            $table->string('state');
            $table->string('city');
//$table->integer('priority')->default(1)->nullable();
            $table->enum('priority', ['0', '1'])->default('0')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->nullable();
           // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('card_details');
    }
};
