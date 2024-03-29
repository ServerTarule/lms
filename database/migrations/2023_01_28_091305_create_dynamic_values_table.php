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
        Schema::create('dynamic_values', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('dependent_id')->nullable()->constrained();
            $table->timestamps();
            $table->foreign('parent_id')
            ->references('id')
            ->on('dynamic_mains')
            ->onDelete('cascade');
            $table->foreign('dependent_id')
                ->references('id')
                ->on('dynamic_mains')
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
        Schema::dropIfExists('dynamic_values');
    }
};
