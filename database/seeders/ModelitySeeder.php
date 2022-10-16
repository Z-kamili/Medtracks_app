<?php

namespace Database\Seeders;

use App\Models\Modality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ModelitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modalities')->delete();
        $modalities = [
            ['name' => 'Scanner','type_id'=>3],
            ['name' => 'IRM','type_id'=>3],
            ['name' => 'Radiologie','type_id'=>3],
            ['name' => 'Mammographie','type_id'=>3],
            ['name' => 'Médecine Nucléaire','type_id'=>3],
            ['name' => 'Echographie','type_id'=>3],
        ];
        foreach ($modalities as $modality){
            Modality::create($modality);
        }
    }
}
