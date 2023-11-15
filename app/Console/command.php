<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RakutenService;
use App\Models\Comic;

class ImportComicsFromRakuten extends Command
{
    protected $signature = 'rakuten:import-comics';
    protected $description = 'Imports comics data from Rakuten API';

    protected $rakutenService;

    public function __construct(RakutenService $rakutenService)
    {
        parent::__construct();
        $this->rakutenService = $rakutenService;
    }

    public function handle()
    {
        $this->info('Importing comics data from Rakuten...');

        $comicsData = $this->rakutenService->getComicsData();

        foreach ($comicsData as $comicData) {
            // ここで取得したデータを`comics`テーブルのカラムに合わせて加工する
            Comic::updateOrCreate(
                ['title' => $comicData['title']],
                [
                    'overview' => $comicData['overview'],
                    'released_at' => $comicData['release_date'],
                    'image' => $comicData['image_url'],
                    // その他のフィールド...
                ]
            );
        }

        $this->info('Importing completed successfully.');
    }
}
