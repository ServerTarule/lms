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
            $table->string('lead_id');
            $table->string('name');
            $table->string('email');
            $table->string('mobileno');
            $table->string('master1');
            $table->string('master2');
            $table->string('master3');
            $table->string('treatmenttype');
            $table->string('casetype');
            $table->string('socialintegration');
            $table->string('location');
            $table->string('casestatus');
            $table->dateTime('receiveddate');
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
        Schema::dropIfExists('leads');
    }
};
