<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SendStatisticsEmail;

class ConsoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            SendStatisticsEmail::class,
        ]);
    }

    public function boot(Schedule $schedule)
    {
        $schedule->command('email:send-statistics')->daily(); // Запуск ежедневно
    }
}
