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
            'title' => 'ワンピース',
            'overview' => '海賊',
            'released_at' => '2023_10_01',   
            ]);
        
        DB::table('comics')->insert([
            'title' => '呪術',
            'overview' => '呪',
            'released_at' => '2023_11_01',   
            ]);
            
        DB::table('comics')->insert([
            'title' => '鬼滅',
            'overview' => '鬼',
            'released_at' => '2023_12_01',   
            ]);
    }
}
