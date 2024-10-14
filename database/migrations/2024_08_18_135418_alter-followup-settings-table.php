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
        DB::statement("ALTER TABLE `follow_up_settings`
        ADD COLUMN `follow_up_rule_type` ENUM('interval', 'monthly') NOT NULL DEFAULT 'interval',
        ADD COLUMN `month_offset` INT(11) NULL");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement('ALTER TABLE `follow_up_settings` DROP COLUMN `follow_up_rule_type`');
        DB::statement('ALTER TABLE `follow_up_settings` DROP COLUMN `month_offset`');

    }
};
