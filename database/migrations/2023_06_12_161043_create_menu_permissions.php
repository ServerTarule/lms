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
        Schema::create('menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id')->nullable()->constrained();
            $table->unsignedBigInteger('employee_id')->nullable()->constrained();
            $table->tinyInteger('add_permission')->nullable()->constrained();
            $table->tinyInteger('edit_permission')->nullable()->constrained();
            $table->tinyInteger('delete_permission')->nullable()->constrained();
            $table->tinyInteger('view_permission')->nullable()->constrained();
            $table->timestamps();
            $table->unique([
                'menu_id',
                'employee_id',
            ],"menuid_employeeid_unique");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_menu_permissions');
    }
};
