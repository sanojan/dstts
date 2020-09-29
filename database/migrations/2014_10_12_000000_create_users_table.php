<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name_w_initial',100);
            $table->string('fullname', 150);
            $table->string('gender',6);
            $table->date('dob')->nullable();
            $table->string('nic',12)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('mobile_number', 10)->unique()->nullable();
            $table->string('designation',30);
            $table->string('service',50);
            $table->char('class');
            $table->string('workplace',30);
            $table->string('branch',15);
            $table->string('subject',30);
            $table->string('user_type',10);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
