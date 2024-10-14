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
        DB::statement('ALTER TABLE leadcalls ADD connected BOOLEAN NOT NULL DEFAULT FALSE AFTER remind_at, ADD connected_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER connected');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement('ALTER TABLE `leadcalls` DROP `connected`');
        DB::statement('ALTER TABLE `leadcalls` DROP `connected_at`');

    }
};
