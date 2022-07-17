<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuelstations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workplace_id');
            $table->string('name');
            $table->string('address');
            $table->integer('no_of_pumbs');
            $table->string('station_type');
            $table->string('contact_no');
            $table->string('owner_name')->nullable();
            $table->string('status');

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('workplace_id')->references('id')->on('workplaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuel_stations');
    }
}
