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
        Schema::create('user_meta_data', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id'); 
            $table->unique('user_id');
            $table->text('address')->nullable();
            $table->string('phno', 15)->nullable(); 
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('zipcode', 10)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('company_name')->nullable();
            $table->string('avatar')->nullable(); 
            $table->timestamps();
            $table->softDeletes();   
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
        Schema::dropIfExists('user_meta_data');
    }
};
