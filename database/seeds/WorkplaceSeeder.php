<?php

use Illuminate\Database\Seeder;

class WorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert workplace type to workplacetype table
        DB::table('workplaces')->insert(array(
            array(
            'workplace_type_id' => '1',
            'name' => 'Ampara-District Secretariat'

            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Ampara-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Alayadivembu-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Uhana-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Mahaoya-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Padiyathalawa-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Dehiaththakandiya-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Damana-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Lahugala-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Irakkamam-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Sammanthurai-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Karathivu-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Sainthamaruthu-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Ninthavur-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Addalachchenai-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Navithanveli-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Akkaraipaththu-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Thirukkovil-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Pothuvil-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Kalmunai-Divisional Secretariat'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Kalmunai(Tamil)-Divisional Secretariat'
            ),
        ));
    }
}
