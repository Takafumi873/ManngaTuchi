<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class ComicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     
    public function run()
    {
        DB::table('comics')->insert([
            'title' => '呪術回線　２巻',
            'overview' => '呪術',
            'released_at' => '2023_11_05',   
            ]);
        
    }
}
