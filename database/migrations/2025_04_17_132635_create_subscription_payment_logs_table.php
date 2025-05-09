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
        Schema::create('subscription_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('transaction_id')->nullable(); // Stripe PaymentIntent ID
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 10)->default('usd');
            $table->enum('status', ['initiated', 'succeeded', 'failed', 'pending'])->default('initiated');
            $table->string('payment_method')->nullable(); // stripe, upi, etc.
            $table->json('subscription_items')->nullable(); // Raw input
            $table->json('stripe_response')->nullable();
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
        Schema::dropIfExists('subscription_payment_logs');
    }
};
