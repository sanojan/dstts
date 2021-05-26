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
            'name' => 'Ampara-District Secretariat',
            'short_code' => 'AM'

            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Ampara-Divisional Secretariat',
                'short_code' => 'AMP'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Alayadivembu-Divisional Secretariat',
                'short_code' => 'ALV'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Uhana-Divisional Secretariat',
                'short_code' => 'DSU'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Mahaoya-Divisional Secretariat',
                'short_code' => 'DSM'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Padiyathalawa-Divisional Secretariat',
                'short_code' => 'DSP'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Dehiaththakandiya-Divisional Secretariat',
                'short_code' => 'DAK'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Damana-Divisional Secretariat',
                'short_code' => 'DSD'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Lahugala-Divisional Secretariat',
                'short_code' => 'LAH'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Irakkamam-Divisional Secretariat',
                'short_code' => 'IRK'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Sammanthurai-Divisional Secretariat',
                'short_code' => 'SMT'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Karathivu-Divisional Secretariat',
                'short_code' => 'KTV'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Sainthamaruthu-Divisional Secretariat',
                'short_code' => 'SAM'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Ninthavur-Divisional Secretariat',
                'short_code' => 'NTR'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Addalachchenai-Divisional Secretariat',
                'short_code' => 'ADD'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Navithanveli-Divisional Secretariat',
                'short_code' => 'NAV'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Akkaraipaththu-Divisional Secretariat',
                'short_code' => 'AKP'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Thirukkovil-Divisional Secretariat',
                'short_code' => 'TKV'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Pothuvil-Divisional Secretariat',
                'short_code' => 'PVL'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Kalmunai-Divisional Secretariat',
                'short_code' => 'KAL'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Kalmunai(Tamil)-Divisional Secretariat',
                'short_code' => 'KMN'
            ),
        ));
    }
}
