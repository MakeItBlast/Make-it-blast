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
        Schema::create('contact_import_data', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger('user_id'); // Foreign Key to users table
            $table->unsignedBigInteger('contact_type_id'); // Foreign Key for contact type
            $table->string('c_fname'); // First Name
            $table->string('c_lname'); // Last Name
            $table->string('c_email')->unique(); // Email
            $table->string('c_phno', 15)->nullable(); // Phone Number
            $table->string('c_city')->nullable(); // City
            $table->string('c_state')->nullable(); // State
            $table->string('c_timezone')->nullable(); // Timezone
           
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // Adds deleted_at for soft delete

            // Foreign Key Constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contact_type_id')->references('id')->on('contact_types')->onDelete('cascade');

        });

       
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_import_data');
    }
};
