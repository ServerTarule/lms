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
        DB::statement('ALTER TABLE `leadcalls` CHANGE `created_at` `created_at` DATE NULL DEFAULT NULL');
        DB::statement('ALTER TABLE leadcalls ADD connection_number INTEGER NOT NULL DEFAULT 0 AFTER connected_at');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `leadcalls` CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE `leadcalls` DROP `connection_number`');
    }
};
