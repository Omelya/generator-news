<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class AnalyzeText extends Command
{
    protected $signature = 'text:analyze {comm?} {arg?}';

    protected $description = 'Analyse command';

    public function handle(): void
    {
        $process = new Process([
            './vendor/yooper/php-text-analysis/textconsole',
            $this->argument('comm'),
            $this->argument('arg'),
        ]);

        $process->run();

        if ($process->isSuccessful()) {
            $this->info($process->getOutput());
        } else {
            $this->error($process->getErrorOutput());
        }
    }
}
