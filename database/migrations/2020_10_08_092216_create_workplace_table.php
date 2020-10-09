<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkplaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workplaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workplace_type_id');
            $table->string('name',100);
            $table->string('address')->nullable();
            $table->string('institute_head',50)->nullable();
            $table->string('contack_no', 10)->unique()->nullable();
            $table->timestamps();
            $table->foreign('workplace_type_id')->references('id')->on('workplace_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workplaces');
    }
}
