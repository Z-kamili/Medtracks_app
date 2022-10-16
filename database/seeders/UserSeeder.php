<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = [
            ['email' => 'contact@medtracks.fr','password'=>Hash::make('bp5heeNTTLc6UDjv'),'email_verified_at'=> date("Y-m-d H:i:s", strtotime('now')), 'role'=>'admin' ],
            ['email' => 'pm@medtracks.fr','password'=>Hash::make('V6W7rF3nuR'),'email_verified_at'=> date("Y-m-d H:i:s", strtotime('now')), 'role'=>'professional' ],
            ['email' => 'es@medtracks.fr','password'=>Hash::make('4kE9tx8uM7'),'email_verified_at'=> date("Y-m-d H:i:s", strtotime('now')), 'role'=>'establishment' ],
        ];

        foreach ($users as $user){
            User::create($user);
        }
        
    }
}

