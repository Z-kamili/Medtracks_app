<?php

namespace Database\Seeders;

    use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->delete();
        $types = [
            ['name' => 'Hopital/Clinique' ],
            ['name' => 'Etablissement Médico-Social' ],
            ['name' => 'Centre d\'Imagerie Médicale' ],
            ['name' => 'Cabinet infirmier libéral' ],
        ];
        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
