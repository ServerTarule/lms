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
        Schema::create('ruleconditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_id');
            $table->unsignedBigInteger('master_id');
            $table->unsignedBigInteger('mastervalue_id');
            $table->string('condition')->nullable();
            $table->foreign('rule_id')
                ->references('id')
                ->on('rules')
                ->onDelete('cascade');
            $table->foreign('master_id')
                ->references('id')
                ->on('dynamic_mains')
                ->onDelete('cascade');
            $table->foreign('mastervalue_id')
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
        Schema::dropIfExists('rulecondition');
    }
};
