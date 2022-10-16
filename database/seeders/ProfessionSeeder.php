<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('professions')->delete();
        $Professions = [
            ['name' => 'infirmier[-ère]'],
            ['name' => 'Manipulateur radio' ],
            ['name' => 'Aide-Soignant[-e]' ],
            ['name' => 'IDE' ],
            ['name' => 'IADE' ],
            ['name' => 'IBODE' ],
            ['name' => 'IDEL' ],
        ];
        foreach ($Professions as $Profession) {
            Profession::create($Profession);
        }
    }
}
