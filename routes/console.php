<?php

use Illuminate\Support\Facades\Schedule;
use App\Services\RssReaderService;

Schedule::call(static fn() => (new RssReaderService())->run())
    ->everyThirtyMinutes();
