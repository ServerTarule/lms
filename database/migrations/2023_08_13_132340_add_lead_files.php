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
    
        DB::statement('CREATE TABLE `leadfiles` (
            `id` bigint(20) NOT NULL,
            `lead_id` int(20) NOT NULL,
            `file_name` varchar(256) NOT NULL,
            `file_path` text NOT NULL,
            `file_size` int(11) NOT NULL,
            `file_type` varchar(256) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT NULL,
            `deleted` tinyint(1) NOT NULL DEFAULT 0
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
        DB::statement('ALTER TABLE `leadfiles`
        ADD PRIMARY KEY (`id`)');

        DB::statement('ALTER TABLE `leadfiles`
        ADD PRIMARY KEY (`id`)');
        DB::statement('ALTER TABLE `leadfiles`
        MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
        COMMIT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TABLE `lms`.`leadfiles`");
        //
    }
};
