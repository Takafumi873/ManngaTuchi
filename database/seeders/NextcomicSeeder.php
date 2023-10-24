<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class NextcomicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nextcomics')->insert([
            'title' => '呪術回戦10巻',
            'overview' => '呪い',
            'released_at' => '2023_11_20',   
            ]);
    }
}
