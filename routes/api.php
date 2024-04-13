<?php

use App\Services\RssReaderService;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    (new RssReaderService())
        ->getFeed('https://dou.ua/lenta/articles/dou-podcast-68/');
});
