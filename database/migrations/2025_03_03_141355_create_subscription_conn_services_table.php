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
        Schema::create('subscription_conn_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id'); 
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->unsignedBigInteger('service_id'); 
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
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
        Schema::dropIfExists('subscription_conn_services');
    }
};
