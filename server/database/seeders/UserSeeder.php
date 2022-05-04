<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Rashikala',
            'email' => 'rashikala.weerawarna@holmesglen.edu.au',
            'user_type'=> 'Owner',
            'user_status'=> 'Active',
            'password' => Hash::make('password'),
        ]);
    }
}
