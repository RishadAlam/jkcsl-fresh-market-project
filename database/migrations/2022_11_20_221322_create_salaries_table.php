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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('month');
            $table->integer('total_sale');
            $table->integer('salery_percentage');
            $table->integer('expence');
            $table->integer('present_bonus');

            $table->integer('extra_1')
                ->comment('চা-নাস্তা');

            $table->integer('extra_2')
                ->comment('গাড়ি ভাড়া');

            $table->integer('extra_3')
                ->comment('মোবাইল বিল');

            $table->integer('basic_salary');
            $table->integer('total_salary');
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
        Schema::dropIfExists('salaries');
    }
};
