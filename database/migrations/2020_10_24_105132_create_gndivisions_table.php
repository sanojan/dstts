<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGndivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gndivisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ds_id');
            $table->string('name', 100);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('ds_id')->references('id')->on('dsdivisions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gndivisions');
    }
}
