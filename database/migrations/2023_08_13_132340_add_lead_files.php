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
    
        DB::statement('CREATE TABLE `lms`.`lead_files` (`id` BIGINT NOT NULL AUTO_INCREMENT , `lead_id` BIGINT NOT NULL , `file_name` VARCHAR(256) NOT NULL , `file_path` TEXT NOT NULL , `file_size` INT(11) NOT NULL , `file_type` INT(11) NOT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP NOT NULL , `deleted` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`)) ENGINE = InnoDB');
        DB::statement('ALTER TABLE `lead_files` ADD FOREIGN KEY (`lead_id`) REFERENCES `leads`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT');
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
