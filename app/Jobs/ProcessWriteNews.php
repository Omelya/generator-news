<?php

namespace App\Jobs;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ProcessWriteNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(
        public ?string $title,
        public ?string $description,
        public ?string $permalink,
        public array $titleTrigram,
        public array $descriptionTrigram,
    ) {}

    public function handle(): void
    {
        $encodeTitle = Json::encode($this->titleTrigram);
        $encodeDescription = Json::encode($this->descriptionTrigram);

        News::firstOrCreate(
            ['url' => $this->permalink ?? ''],
            [
                'title' => $this->title ?? '',
                'description' => $this->description ?? '',
                'title_trigram' => $encodeTitle,
                'description_trigram' => $encodeDescription,
            ],
        );
    }
}
