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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('father_name')->nullable();
            $table->string('phone', 11)->unique()->nullable();
            $table->string('phone2', 11)->unique()->nullable();
            $table->string('nid', 30)->unique()->nullable();
            $table->date('dob')->nullable();
            $table->string('blood')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default('2');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
