<?php

use Illuminate\Database\Seeder;

class DSDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert DS Division to dsdivision table
        DB::table('dsdivisions')->insert(array(
                array(
                    'name' => 'Ampara'
                ),
                array(
                    'name' => 'Alayadivembu'
                ),
                array(
                    'name' => 'Uhana'
                ),
                array(
                    'name' => 'Mahaoya'
                ),
                array(
                    'name' => 'Padiyathalawa'
                ),
                array(
                    'name' => 'Dehiaththakandiya'
                ),
                array(
                    'name' => 'Damana'
                ),
                array(
                    'name' => 'Lahugala'
                ),
                array(
                    'name' => 'Irakkamam'
                ),
                array(
                    'name' => 'Sammanthurai'
                ),
                array(
                    'name' => 'Karathivu'
                ),
                array(
                    'name' => 'Sainthamaruthu'
                ),
                array(
                    'name' => 'Ninthavur'
                ),
                array(
                    'name' => 'Addalachchenai'
                ),
                array(
                    'name' => 'Navithanveli'
                ),
                array(
                    'name' => 'Akkaraipaththu'
                ),
                array(
                    'name' => 'Thirukkovil'
                ),
                array(
                    'name' => 'Pothuvil'
                ),
                array(
                    'name' => 'Kalmunai(Muslim)'
                ),
                array(
                    'name' => 'Kalmunai(Tamil)'
                ),
            ));
    }
}
