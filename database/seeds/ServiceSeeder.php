<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert Services to services table
        DB::table('services')->insert(array(
            array(
                'name' => 'Sri Lanka Administrative Service'
            ),
            array(
                'name' => 'Sri Lanka Engineering Service'
            ),
            array(
                'name' => 'Sri Lanka Accountants Service'
            ),
            array(
                'name' => 'Sri Lanka Planning Service'
            ),
            array(
                'name' => 'Sri Lanka Scientific Service'
            ),
            array(
                'name' => 'Sri Lanka Architectural Service'
            ),
            array(
                'name' => 'Sri Lanka Information & Communication Technology Service'
            ),
            array(
                'name' => 'Government Translators Service'
            ),
            array(
                'name' => 'Sri Lanka Librarians Service'
            ),
            array(
                'name' => 'Development Officers Service'
            ),
            array(
                'name' => 'Management Service Officers Service'
            ),
            array(
                'name' => 'Combined Drivers Service'
            ),
            array(
                'name' => 'Office Employees Service'
            ),
            array(
                'name' => 'Sri Lanka Technological Service'
            ),
            array(
                'name' => 'Registrar Service'
            ),
        ));
    }
}
