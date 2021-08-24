<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workplace_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('file_no', 50);
            $table->string('file_name', 100);
            $table->string('file_branch', 50);
            $table->string('file_desc', 150);
            $table->timestamps();

            $table->foreign('workplace_id')->references('id')->on('workplaces')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
