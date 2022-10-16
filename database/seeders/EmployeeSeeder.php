<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->delete();
        DB::table('employees')->insert([
            'name'=>'admin',
            'role_id'=>1,
            'user_id'=> 3,
            'es_id'=>1,
        ]); 
    }
}
