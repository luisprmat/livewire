<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
