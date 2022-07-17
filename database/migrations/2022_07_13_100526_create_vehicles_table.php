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
            $table->string('vehicle_no', 15)->nullable();
            $table->string('vehicle_type', 25)->nullable();
            $table->string('fuel_type', 10);
            $table->string('owner_name');
            $table->string('owner_gender', 6);
            $table->string('owner_id', 12);
            $table->string('owner_job')->nullable();
            $table->string('owner_workplace')->nullable();
            $table->string('perm_address')->nullable();
            $table->string('perm_district')->nullable();
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
