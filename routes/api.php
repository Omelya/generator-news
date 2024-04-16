<?php

use App\Services\RssReaderService;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    (new \App\Services\CsvServices())
        ->generate();
});
