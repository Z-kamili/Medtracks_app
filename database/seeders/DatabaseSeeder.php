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
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            TypeSeeder::class,
            ProfessionSeeder::class,
            ServiceSeeder::class,
            ModelitySeeder::class,
            ProfessionType::class,
            Type_annonceSeeder::class,
            ProfessionalSeeder::class,
            EstablishmentSeeder::class,
            RoleSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
