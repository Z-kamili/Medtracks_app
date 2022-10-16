<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        $roles = [
            ['name' => 'Admin' ],
            ['name' => 'RESPONSABLE' ],
            ['name' => 'cadre de service' ],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
