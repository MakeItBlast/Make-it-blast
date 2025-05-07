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
        Schema::create('blast_answers', function (Blueprint $table) {
            $table->id(); // Primary Key 
            $table->text('answer'); // Answer text
           
            $table->unsignedBigInteger('contact_id'); // Foreign key reference to contacts table
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // Adds deleted_at for soft delete

            // Foreign Key Constraints
    
            $table->foreign('contact_id')->references('id')->on('contact_import_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blast_answers');
    }
};
