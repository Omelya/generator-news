<?php

use App\Services\CsvServices;
use Illuminate\Support\Facades\Schedule;
use App\Services\RssReaderService;

Schedule::call(static fn() => (new RssReaderService())->run())
    ->everyThirtyMinutes();

Schedule::call(static fn() => (new CsvServices())->generate())
    ->daily();
