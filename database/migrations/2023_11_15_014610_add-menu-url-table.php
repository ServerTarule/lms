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
        // Create Table Statement Here
        DB::statement('CREATE TABLE `menu_urls` (
            `id` bigint(20) NOT NULL,
            `name` text NOT NULL,
            `url` text NOT NULL,
            `deleted` tinyint(1) NOT NULL DEFAULT 0,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT NULL,
            `deleted_at` timestamp NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');

        DB::statement('ALTER TABLE `menu_urls`
        ADD PRIMARY KEY (`id`)');

        DB::statement('ALTER TABLE `menu_urls` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT');

        DB::statement('ALTER TABLE `menu_urls` ADD UNIQUE `Unique Menu Name Url` (`name`(100), `url`(100))');
        
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop Table Statement Here
        DB::statement("DROP TABLE `lms`.`leadfiles`");
    }
};
