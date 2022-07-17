<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFuelCountColumnsToWorkplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workplaces', function (Blueprint $table) {
            //Add Fuel count columns
            $table->char('fuel_count_petrol')->after('sellers_list')->default('0');
            $table->char('fuel_count_diesel')->after('fuel_count_petrol')->default('0');
            $table->char('fuel_count_kerosene')->after('fuel_count_diesel')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workplaces', function (Blueprint $table) {
            //Drop Columns
            $table->dropColumn('fuel_count_petrol');
            $table->dropColumn('fuel_count_diesel');
            $table->dropColumn('fuel_count_kerosene');
        });
    }
}
