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
        DB::statement("ALTER TABLE `templates` ADD `template_type` ENUM('General','Promotional','Reminder','') NOT NULL DEFAULT 'General' AFTER `message`, ADD `isCurrent` BOOLEAN NOT NULL DEFAULT FALSE AFTER `template_type`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement('ALTER TABLE `dynamic_values` DROP `template_type`');
    }
};
