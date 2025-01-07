<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsrs', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('today_work')->nullable(); // Column for today's work summary
            $table->text('comment')->nullable(); // Column for additional comments
            $table->enum('status', ['in_progress', 'completed', 'not_started'])->default('not_started'); // Status column
            $table->time('time_taken')->nullable(); // Time taken (HH:MM:SS format)
            $table->unsignedBigInteger('created_by'); // User ID who created the record
            $table->timestamps(); // Created at and updated at

            // Foreign key constraint (if 'users' table exists)
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dsrs');
    }
}

