<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            WorkplaceTypeSeeder::class,
            WorkplaceSeeder::class,
            DSDivisionSeeder::class,
            GNDivisionSeeder::class,
            DesignationSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
