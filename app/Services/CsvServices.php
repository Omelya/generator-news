<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\File;
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

        foreach (News::lazy() as $item)
        {
            fputcsv($csv, ["$item->title $item->description"]);
        }

        fclose($csv);

        Storage::putFileAs('public', $this->fileName, $this->fileName);
    }
}
