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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobileno');
            $table->string('altmobileno')->nullable();
            $table->dateTime('receiveddate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->longText('remark')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable()->constrained();
            $table->timestamps();
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
