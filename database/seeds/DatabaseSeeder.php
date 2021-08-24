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
            WorkplaceTypeSeeder::class,
            WorkplaceSeeder::class,
            AdminSeeder::class,
            DSDivisionSeeder::class,
            GNDivisionSeeder::class,
            DesignationSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
