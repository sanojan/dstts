<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('nic',12);
            $table->date('dob');
            $table->string('email')->nullable();
            $table->string('mobile_no', 10);
            $table->string('dsdivision', 35);
            $table->string('gndivision', 45);
            $table->string('permanant_address', 100);
            $table->string('temporary_address', 100)->nullable();
            $table->foreignId('user_id');
            $table->longText('complaint_content');
            $table->string('complaint_scanned_copy')->nullable();
            $table->unsignedBigInteger('ref_no')->nullable();
            $table->string('status', 30)->nullable();
            $table->string('complaint_report')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}
