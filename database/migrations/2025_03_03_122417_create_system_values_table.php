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
        Schema::create('system_values', function (Blueprint $table) {
            $table->id();
            $table->decimal('yearly_discount', 8, 2); // Yearly discount field (decimal type)
            $table->decimal('cost_per_blast', 10, 2); // Cost per blast (decimal type)
            $table->decimal('dollar_value', 10, 2); // Cost per blast (decimal type)
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
        Schema::dropIfExists('system_values');
    }
};
