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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name'); // Service name (string column)
            $table->text('service_desc'); // Service description (text column for longer content)
            $table->unsignedBigInteger('system_value_id'); 
            $table->enum('flat_rate', ['active', 'inactive'])->default('inactive'); // Status column with a default value of 'active'
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status column with a default value of 'active'
            $table->timestamps();
            //connection
            $table->foreign('system_value_id')->references('id')->on('system_values')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
