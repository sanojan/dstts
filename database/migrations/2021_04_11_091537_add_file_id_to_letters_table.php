<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileIdToLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            //Add file_id column
            $table->foreignId('file_id')->nullable()->after('user_id');
            $table->string('letter_type', 30)->after('letter_no');
            $table->string('letter_reg_no', 30)->after('letter_no')->nullable();

            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letters', function (Blueprint $table) {
            //Remove Column
            $table->dropColumn('file_id');
            $table->dropColumn('letter_type');
            $table->dropColumn('letter_reg_no');
        });
    }
}
