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
        Schema::create('leadcalls', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->constrained();
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('employee_id')->nullable()->constrained();
            $table->unsignedBigInteger('leadstatus_id')->nullable()->constrained();
            $table->longText('remark')->nullable();
            $table->dateTime('called_at')->nullable();
            $table->date('remind_at')->nullable();
            $table->foreign('lead_id')
                ->references('id')
                ->on('leads')
                ->onDelete('cascade');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
            $table->foreign('leadstatus_id')
                ->references('id')
                ->on('dynamic_values')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leadcalls');
    }
};
