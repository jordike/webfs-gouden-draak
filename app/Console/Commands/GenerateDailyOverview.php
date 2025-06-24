<?php

namespace App\Console\Commands;

use App\Jobs\GenerateDailyOverview as GenerateDailyOverviewJob;
use Illuminate\Console\Command;

class GenerateDailyOverview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-daily-overview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a daily overview of orders and sales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        GenerateDailyOverviewJob::dispatch();
    }
}
