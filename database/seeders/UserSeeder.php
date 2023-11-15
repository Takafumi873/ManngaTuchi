<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user.1',
            'email' => '1@1',
            'password' => Hash::make('1'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]);
            
        DB::table('users')->insert([
            'name' => 'user.2',
            'email' => '2@2',
            'password' => Hash::make('2'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]);   
    }
}
