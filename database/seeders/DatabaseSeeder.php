<?php

namespace Database\Seeders;

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
        $this-> call([
            UserSeeder::class,
            ProjekSeeder::class,
            UploaderSeeder::class,
            RevisiSeeder::class,
            DokumenSeeder::class,
            
        ]);
    }
}
