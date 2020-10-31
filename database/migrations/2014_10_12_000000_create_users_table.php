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
            $table->string('name',100);
            $table->string('gender',6)->nullable();
            $table->date('dob')->nullable();
            $table->string('nic',12)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('mobile_no', 10)->unique();
            $table->string('designation',50);
            $table->string('service',50);
            $table->char('class');
            $table->string('workplace',100);
            $table->string('branch',15)->nullable();
            $table->string('subject',30)->nullable();
            $table->string('user_type',10)->default('user');
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
