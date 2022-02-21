<?php

namespace App\Console;

use App\Jobs\NewsJob;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new NewsJob())
            ->description('News api cron work')
             ->everyMinute();
    }

    protected function shortSchedule(\Spatie\ShortSchedule\ShortSchedule $shortSchedule)
    {
        // this artisan command will run every second

        $shortSchedule->job(new NewsJob())
            ->description('News api cron work')
            ->everyMinute();

        // this artisan command will run every second, its signature will be resolved from container
        $shortSchedule->command(\Spatie\ShortSchedule\Tests\Unit\TestCommand::class)->everySecond();
    }
}
