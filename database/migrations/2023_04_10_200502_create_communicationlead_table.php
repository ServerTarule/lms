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
        Schema::create('communicationleads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('communication_id');
            $table->unsignedBigInteger('rule_id');
            $table->unsignedBigInteger('lead_id');
            $table->foreign('communication_id')
                ->references('id')
                ->on('communications')
                ->onDelete('cascade');
            $table->foreign('rule_Id')
                ->references('id')
                ->on('rules')
                ->onDelete('cascade');
            $table->foreign('lead_id')
                ->references('id')
                ->on('leads')
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
        Schema::dropIfExists('communicationlead');
    }
};
