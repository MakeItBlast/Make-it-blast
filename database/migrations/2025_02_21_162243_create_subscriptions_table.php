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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('subsc_name'); // Subscription name
            $table->integer('keyword_allowed_count'); // Number of keywords allowed
            $table->integer('duration'); // Duration of the subscription (e.g., in months)
            $table->decimal('credit_cost', 10, 2); // Cost in credits
            $table->decimal('monthly_cost', 10, 2); // Monthly cost of the subscription
            $table->decimal('discount', 5, 2)->default(0); // Discount applied to the subscription (percentage)
            $table->decimal('yearly_cost', 10, 2); // Yearly cost of the subscription
            $table->decimal('surcharge', 10, 2)->default(0); // Surcharge (optional extra charge)
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active'); // Subscription status
            $table->timestamps(); // Timestamps for created_at and updated_at
            $table->softDeletes(); // Soft delete column (deleted_at) for soft deleting records
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
