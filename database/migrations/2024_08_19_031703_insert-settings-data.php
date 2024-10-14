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
        DB::statement("INSERT INTO `follow_up_settings` ( `follow_up_sequence`, `follow_up_desc`, `follow_up_type`, `follow_up_interval`, `follow_up_rule_type`, `month_offset`) VALUES
        (1, '3 days after 1st connect', 2, 3, 'interval', NULL),
        (2, '5 days after 2nd connect', 2, 5, 'interval', NULL),
        (3, '10 days after 3rd conenct', 2, 10, 'interval', NULL),
        (4, 'Monthly reassignment', 2, NULL, 'monthly', 2),
        (5, 'This Is Follow Up Number , which will run after 15 days', 1, 15, 'interval', NULL)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("TRUNCATE TABLE `follow_up_settings`");
    }
};
