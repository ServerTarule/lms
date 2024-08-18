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
        DB::statement("ALTER TABLE `follow_up_settings` CHANGE `follow_up_no` `follow_up_no` BIGINT(20) NULL");
        DB::statement("ALTER TABLE `follow_up_settings` CHANGE `follow_up_interval` `follow_up_interval` BIGINT(20) NULL");
        DB::statement("ALTER TABLE `follow_up_settings` CHANGE `follow_up_no` `follow_up_sequence` BIGINT(20) NULL DEFAULT NULL");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("ALTER TABLE `follow_up_settings` CHANGE `follow_up_no` `follow_up_no` BIGINT(20) NOT NULL");
        DB::statement("ALTER TABLE `follow_up_settings` CHANGE `follow_up_interval` `follow_up_interval` BIGINT(20) NOT NULL");
        DB::statement("ALTER TABLE `follow_up_settings` CHANGE `follow_up_sequence` `follow_up_no` BIGINT(20) NULL DEFAULT NULL");
    }
};
