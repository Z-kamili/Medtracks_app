<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profession_type')->delete();
        $profession = Profession::get()->all();
        $profession[1]->types()->sync([1,3]);
        $profession[2]->types()->sync([1,2,3]);
        $profession[3]->types()->sync([1,2,4]);
        $profession[4]->types()->sync([1,2,4]);
        $profession[5]->types()->sync([1,2,4]);
        $profession[6]->types()->sync([1,2,3]);
    }
}
