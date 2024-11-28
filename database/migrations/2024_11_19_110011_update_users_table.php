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
        Schema::table('users', function (Blueprint $table) {
            $table->string('staff_id')->nullable()->after('id'); // Employee ID
            $table->string('user_name')->nullable()->after('name');
            $table->enum('role', ['Super Admin', 'Manager', 'Staff'])->default('Staff')->after('user_name');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('role');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('phone')->nullable()->after('date_of_birth');
            $table->string('image')->nullable()->after('phone');
            $table->string('firebase_token')->nullable()->after('image');
            $table->text('address')->nullable()->after('firebase_token');
            $table->string('postcode')->nullable()->after('address');
            $table->text('description')->nullable()->after('postcode');
            $table->boolean('status')->default(1)->after('description'); // Active/Inactive
            $table->unsignedBigInteger('created_by')->nullable()->after('status'); // Tracks the creator of the record
            $table->softDeletes()->after('updated_at'); // Adds the deleted_at column for soft deletes
            $table->string('country')->nullable()->after('deleted_at');
            $table->string('state')->nullable()->after('country');
            $table->string('dial_code')->nullable()->after('state');
            $table->boolean('is_test')->default(0)->after('dial_code'); // Tracks test users
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'staff_id',
                'user_name',
                'role',
                'gender',
                'date_of_birth',
                'phone',
                'image',
                'firebase_token',
                'address',
                'postcode',
                'description',
                'status',
                'created_by',
                'deleted_at',
                'country',
                'state',
                'dial_code',
                'is_test',
            ]);
        });
    }
};
