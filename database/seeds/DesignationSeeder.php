<?php

use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert Designations to designations table
        DB::table('designations')->insert(array(
            array(
                'name' => 'District Secretary'
            ),
            array(
                'name' => 'Additional District Secretary'
            ),
            array(
                'name' => 'Chief Accountant'
            ),
            array(
                'name' => 'Director Planning'
            ),
            array(
                'name' => 'Divisional Secretary'
            ),
            array(
                'name' => 'Assistant Divisional Secretary'
            ),
            array(
                'name' => 'Engineer'
            ),
            array(
                'name' => 'Technical Officer'
            ),
            array(
                'name' => 'Assistant District Secretary'
            ),
            array(
                'name' => 'Administrative Officer'
            ),
            array(
                'name' => 'Chief Management Service Officer'
            ),
            array(
                'name' => 'ICT Officer'
            ),
            array(
                'name' => 'Accountant'
            ),
            array(
                'name' => 'Shroff'
            ),
            array(
                'name' => 'MSO Store'
            ),
            array(
                'name' => 'Budjet Assistant'
            ),
            array(
                'name' => 'Pension Officer'
            ),
            array(
                'name' => 'Head of Internal Audit'
            ),
            array(
                'name' => 'Internal Auditor'
            ),
            array(
                'name' => 'Deputy Director Planning'
            ),
            array(
                'name' => 'Assistant Director Planning'
            ),
            array(
                'name' => 'Development Officer'
            ),
            array(
                'name' => 'Administrative Grama Niladari'
            ),
            array(
                'name' => 'Samurdhi Head Quater'
            ),
            array(
                'name' => 'Samurdhi Managing Director'
            ),
            array(
                'name' => 'Samurdhi Bank Manager'
            ),
            array(
                'name' => 'Project Manager'
            ),
            array(
                'name' => 'Samurdhi Development Officer'
            ),
            array(
                'name' => 'ICT Assistant'
            ),
            array(
                'name' => 'Management Service Officer'
            ),
            array(
                'name' => 'Financial Assistant'
            ),
            array(
                'name' => 'Technical Assistant'
            ),
            array(
                'name' => 'Field Officer'
            ),
            array(
                'name' => 'Cultural Officer'
            ),
            array(
                'name' => 'Translator'
            ),
            array(
                'name' => 'Land Officer'
            ),
            array(
                'name' => 'Colonial Officer'
            ),
            array(
                'name' => 'Additional District Registrar'
            ),
            array(
                'name' => 'Rural Development Officer'
            ),
            array(
                'name' => 'Social Service Officer'
            ),
            array(
                'name' => 'Grama Niladari'
            ),
            array(
                'name' => 'Driver'
            ),
            array(
                'name' => 'Office Employment Staff'
            ),
            array(
                'name' => 'Junior Service'
            ),
            array(
                'name' => 'Watcher'
            ),
        ));
    }
}
