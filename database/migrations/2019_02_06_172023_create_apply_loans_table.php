<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_loans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->double('processing_fee', 8, 2);
            $table->double('amount', 8, 2);
            $table->double('interest', 4, 2);
            $table->tinyInteger('tenur');
            $table->string('pan_card');
            $table->double('due_amount', 8, 2);
            $table->timestamp('due_date');
            $table->boolean('isClosed')->default(false);
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
        Schema::dropIfExists('apply_loans');
    }
}
