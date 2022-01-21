<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ForceAssetsRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'styles:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $versionDateKey = 'VERSION_DATE';
        $filePath = __DIR__ . '/../../../.env';

        $configFile = file_get_contents($filePath);
        $indexOfBeginningOfValue = strpos($configFile, $versionDateKey) + strlen($versionDateKey) + 1;
        $relativeIndexOfEndingOfValue = strpos(substr($configFile, $indexOfBeginningOfValue + 1), "\n");
        $configFile = substr_replace($configFile, time(), $indexOfBeginningOfValue, $relativeIndexOfEndingOfValue);
        file_put_contents($filePath, $configFile);
    }
}
