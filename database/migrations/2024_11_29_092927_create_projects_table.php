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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->date('date')->nullable(); 
            $table->enum('status', ['Live', 'Dev'])->default('Dev'); 
            $table->string('url')->nullable(); 
            $table->text('description')->nullable(); 
            $table->unsignedBigInteger('client_id'); 
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
