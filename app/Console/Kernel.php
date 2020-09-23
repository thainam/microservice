<?php

namespace App\Console;

use App\Jobs\SendNotificationEmailJob;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->job(new SendNotificationEmailJob())
        //     ->description('Tarefa para enviar notificações por email das transações realizadas.')
        //     ->everyMinute() // Para testar
        //     ->withoutOverlapping();
    }
}
