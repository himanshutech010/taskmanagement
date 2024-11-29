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
        Schema::create('project_assign', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); 
            $table->unsignedBigInteger('dept_id'); 
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_moderator')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_assign');
    }
};
