<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToWorkplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workplaces', function (Blueprint $table) {
            //Add columns to keep track of applucations
            $table->string('short_code', 5)->after('contact_no');
            $table->char('travelpass_count')->after('short_code')->default('0');
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
            //

            $table->dropColumn('travelpass_count');
            $table->dropColumn('short_code');
        });
    }
}
