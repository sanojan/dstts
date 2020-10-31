<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class WorkplaceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert workplace type to workplacetype table
        DB::table('workplace_types')->insert(array(
            array(
            'name' => 'District Secretariat'

            ),
            array(
            'name' => 'Divisional Secretariat'
            ),
        ));
    }
}
