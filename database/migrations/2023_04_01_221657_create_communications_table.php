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
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('message')->nullable()->constrained();
            $table->string('subject')->nullable()->constrained();
            $table->string('content')->nullable()->constrained();
            $table->string('schedule');
            $table->string('words');
            $table->unsignedBigInteger('template_id')->nullable()->constrained();
            $table->unsignedBigInteger('rule_id')->nullable()->constrained();
            $table->foreign('template_id')
                ->references('id')
                ->on('templates')
                ->onDelete('cascade');
            $table->foreign('rule_id')
                ->references('id')
                ->on('rules')
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
        Schema::dropIfExists('communications');
    }
};
