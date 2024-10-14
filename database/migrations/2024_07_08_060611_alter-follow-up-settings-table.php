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
        DB::statement("ALTER TABLE `follow_up_settings` ADD `follow_up_type` ENUM('Promotional','Non Promotional') NOT NULL DEFAULT 'Non Promotional' AFTER `follow_up_desc`");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement('ALTER TABLE `follow_up_settings` DROP COLUMN `follow_up_type`');

    }
};
