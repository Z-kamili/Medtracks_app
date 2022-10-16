<?php

namespace Database\Seeders;

use App\Models\TypeAnnonce;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Type_annonceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_annonces')->delete();
        $typeannonces = [
            ['name' => 'CDI' ],
            ['name' => 'CDD' ],
        ];
        foreach ($typeannonces as $typeannonce){
            TypeAnnonce::create($typeannonce);
        }
    }
}
