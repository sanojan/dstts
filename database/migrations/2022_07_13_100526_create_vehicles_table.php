<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workplace_id');
            $table->string('ref_no', 20);
            $table->string('vehicle_no', 15);
            $table->string('vehicle_type', 25);
            $table->string('fuel_type', 10);
            $table->string('owner_name');
            $table->string('owner_gender', 6);
            $table->string('owner_nic', 12);
            $table->string('owner_job');
            $table->string('owner_workplace')->nullable();
            $table->string('perm_address');
            $table->string('perm_district');
            $table->string('temp_address')->nullable();
            $table->string('qrcode');
            $table->string('consumer_type');
            $table->integer('allowed_days');
            $table->string('status');
            $table->boolean('print_lock');
            
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
        Schema::dropIfExists('vehicles');
    }
}
