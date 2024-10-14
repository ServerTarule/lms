<?php

use Illuminate\Database\Migrations\Migration;

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
        DB::statement("CREATE TABLE `lead_assignment_log` (`id` BIGINT NOT NULL AUTO_INCREMENT , `lad_id` BIGINT NOT NULL , `from_employee_id` BIGINT NULL , `to_employee_id` BIGINT NOT NULL , `is_fresh_assignment` BOOLEAN NOT NULL DEFAULT FALSE , `is_accepted` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`)) ENGINE = InnoDB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("DROP TABLE `lead_assignment_log` IF EXISTS");
    }
};
