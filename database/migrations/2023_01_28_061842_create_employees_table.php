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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->date('dob');
            $table->date('doj');
            $table->string('alternate_contact');
            $table->unsignedBigInteger('designation_id');
            $table->string('profile_img');
            $table->softDeletes();
            $table->foreign('designation_id')
                ->references('id')
                ->on('designations')
                ->onDelete('cascade');
            $table->foreign('user_Id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('employees');
    }
};
