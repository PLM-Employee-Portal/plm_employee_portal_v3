<?php

namespace App\Console;

use App\Models\Teachpermit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->call(function () {
        //     // Get the latest model data
        //     $latestData = Teachpermit::latest('created_at')->first();
    
        //     if ($latestData) {
        //         // Check if the latest data has already been notified
        //         $lastNotifiedId = Cache::get('last_notified_model_id');
        //         $lastNotifiedContent = Cache::get('last_notified_data_content');
    
        //         if ($latestData->id !== $lastNotifiedId || $latestData->data !== $lastNotifiedContent) {
        //             // Notify the user
        //             Notification::route('mail', 'user@example.com') // Replace with the actual user email
        //                         ->notify(new NewModelDataNotification($latestData));
    
        //             // Update the cache with the latest notified data ID and content
        //             Cache::put('last_notified_model_id', $latestData->id, Carbon::now()->addDay());
        //             Cache::put('last_notified_data_content', $latestData->data, Carbon::now()->addDay());
        //         }
        //     }
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
