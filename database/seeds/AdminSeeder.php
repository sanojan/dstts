<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert Admin user to user table
        DB::table('users')->insert([
            'name' => 'Sytem Admin',
            'gender' => 'Male',
            'nic' => '111111111V',
            'mobile_no' => '1111111111',
            'designation' => 'ICT Officer',
            'service' => 'SLICTS',
            'class' => '2',
            'workplace_id' => '1',
            'user_type' => 'sys_admin',
            'password' => Hash::make('11111111'),
            'account_status' => true

        ]);

    }
}
