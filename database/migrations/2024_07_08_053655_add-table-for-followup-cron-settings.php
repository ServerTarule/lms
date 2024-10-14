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
        //
        Schema::create('follow_up_settings', function (Blueprint $table) {
            $table->id()->unique();
            $table->bigInteger('follow_up_no');
            $table->text('follow_up_desc');
            $table->integer('follow_up_type');
            $table->bigInteger('follow_up_interval');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
