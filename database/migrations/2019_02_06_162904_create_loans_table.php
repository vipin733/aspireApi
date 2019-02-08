<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->double('min_amount', 8, 2);
            $table->double('max_amount', 8, 2);
            $table->double('month_1', 3, 2);
            $table->double('month_2', 3, 2);
            $table->double('month_3', 3, 2);
            $table->double('month_4', 4, 2);
            $table->double('month_5', 4, 2);
            $table->double('month_6', 4, 2);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('loans');
    }
}
