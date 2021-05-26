<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelpassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelpass', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workplace_id');
            $table->string('travelpass_no', 20);
            $table->char('travelpass_type');
            $table->string('applicant_name', 80);
            $table->string('applicant_address', 150)->nullable();
            $table->string('nic_no', 12);
            $table->string('vehicle_no', 12);
            $table->string('vehicle_type', 20)->nullable();
            $table->date('travel_date');
            $table->date('comeback_date')->nullable();
            $table->string('reason_for_travel')->nullable();
            $table->string('passengers_details', 350);
            $table->string('travel_path', 250);
            $table->string('travel_items', 350)->nullable();
            $table->string('travelpass_status', 25);
            $table->string('travelpass_scanned_copy')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->string('travelpass_contact_no', 10)->nullable();

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
        Schema::dropIfExists('travelpass');
    }
}
