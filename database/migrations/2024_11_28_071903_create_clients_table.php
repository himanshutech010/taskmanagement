<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing unsigned BIGINT as 'id' (Primary Key)
            $table->string('client_name', 255)->nullable();
            $table->string('mobile', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('skype', 255)->nullable();
            $table->string('other', 255)->nullable();
            $table->text('location')->nullable();
            $table->boolean('is_test')->default(0); // Boolean (TINYINT 1) with default value 0
            $table->timestamps(); // Adds 'created_at' and 'updated_at' as TIMESTAMP fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
}

