<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->delete();
        $services = [
            ['name' => 'pneumologie/cardiologie','type_id'=>1],
            ['name' => 'nephrologie/urologie','type_id'=>1],
            ['name' => 'neurologie','type_id'=>1],
            ['name' => 'orthopédie','type_id'=>1],
            ['name' => 'hépato-gastro/digestif','type_id'=>1],
            ['name' => 'rhumatologie','type_id'=>1],
            ['name' => 'Médecine interne,hématologie,maladie infectieuses','type_id'=>1],
            ['name' => 'gériatrie','type_id'=>1],
            ['name' => 'pédiatrie','type_id'=>1],
            ['name' => 'oncologie','type_id'=>1],
            ['name' => 'réanimation, soins intensifs, réveil','type_id'=>1],
            ['name' => 'bloc opératoire','type_id'=>1],
            ['name' => 'urgences','type_id'=>1],
            ['name' => 'imagerie médicale','type_id'=>1],
            ['name' => 'EHPAD','type_id'=>2],
            ['name' => 'Maison d\'Accueil Spécialisée','type_id'=>2],
        ];
        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
