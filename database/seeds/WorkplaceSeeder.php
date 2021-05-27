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
            'short_code' => 'AM',
            'contact_no' => '0632222233'

            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Ampara-Divisional Secretariat',
                'short_code' => 'AMP',
                'contact_no' => '0632223435'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Alayadivembu-Divisional Secretariat',
                'short_code' => 'ALV',
                'contact_no' => '0672277436'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Uhana-Divisional Secretariat',
                'short_code' => 'DSU',
                'contact_no' => '0632250426'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Mahaoya-Divisional Secretariat',
                'short_code' => 'DSM',
                'contact_no' => '0632244006'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Padiyathalawa-Divisional Secretariat',
                'short_code' => 'DSP',
                'contact_no' => '0632246035'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Dehiaththakandiya-Divisional Secretariat',
                'short_code' => 'DAK',
                'contact_no' => '0272250167'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Damana-Divisional Secretariat',
                'short_code' => 'DSD',
                'contact_no' => '0632240034'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Lahugala-Divisional Secretariat',
                'short_code' => 'LAH',
                'contact_no' => '0632051851'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Irakkamam-Divisional Secretariat',
                'short_code' => 'IRK',
                'contact_no' => '0632223189'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Sammanthurai-Divisional Secretariat',
                'short_code' => 'SMT',
                'contact_no' => '0672260236'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Karathivu-Divisional Secretariat',
                'short_code' => 'KTV',
                'contact_no' => '0672222036'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Sainthamaruthu-Divisional Secretariat',
                'short_code' => 'SAM',
                'contact_no' => '0672226288'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Ninthavur-Divisional Secretariat',
                'short_code' => 'NTR',
                'contact_no' => '0672050334'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Addalachchenai-Divisional Secretariat',
                'short_code' => 'ADD',
                'contact_no' => '0672055336'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Navithanveli-Divisional Secretariat',
                'short_code' => 'NAV',
                'contact_no' => '0672223256'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Akkaraipaththu-Divisional Secretariat',
                'short_code' => 'AKP',
                'contact_no' => '0672277236'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Thirukkovil-Divisional Secretariat',
                'short_code' => 'TKV',
                'contact_no' => '0672265056'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Pothuvil-Divisional Secretariat',
                'short_code' => 'PVL',
                'contact_no' => '0632248007'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Kalmunai-Divisional Secretariat',
                'short_code' => 'KAL',
                'contact_no' => '0672229236'
            ),
            array(
                'workplace_type_id' => '2',
                'name' => 'Kalmunai(Tamil)-Divisional Secretariat',
                'short_code' => 'KMN',
                'contact_no' => '0672229599'
            ),
        ));
    }
}
