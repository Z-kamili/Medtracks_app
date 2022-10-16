<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('professionals')->delete();
        DB::table('professionals')->insert([
           'first_name' => 'ps_medtracks',
           'user_id'=> 2,
        ]);    
    }
}
