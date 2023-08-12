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
        DB::statement('ALTER TABLE `leads` ADD `state` BIGINT NULL DEFAULT "0" AFTER `receiveddate`');
        DB::statement('ALTER TABLE `leads` ADD `city` BIGINT NULL DEFAULT "0" AFTER `state`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement('ALTER TABLE `leads` DROP `state`');
        DB::statement('ALTER TABLE `leads` DROP `city`');
    }
};
