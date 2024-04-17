<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Storage;

class CsvServices
{
    private string $fileName;

    public function __construct()
    {
        $this->fileName = 'news_' . date('Y-m-d') . '.csv';
    }

    public function generate(): void
    {
        $csv = fopen($this->fileName, 'w+');

        $date = date('Y-m-d 00:00:00', strtotime('-1 day'));

        $news = News::where('created_at', '>=', $date)->lazy();

        foreach ($news as $item)
        {
            fputcsv($csv, ["$item->title $item->description"]);
        }

        fclose($csv);

        Storage::putFileAs('public', $this->fileName, $this->fileName);
    }
}
