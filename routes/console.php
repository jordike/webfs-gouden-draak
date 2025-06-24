<?php

use App\Jobs\GenerateDailyOverview;
use Illuminate\Support\Facades\Schedule;

Schedule::call(GenerateDailyOverview::class)
    ->daily();
