<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Broadcast::routes();
        // Broadcast::routes(['middleware' => ['auth:api']]);
        // Broadcast::routes(['middleware' => ['jwt.verify']]);
        // Broadcast::channel('App.User.*', function ($user, $userId) {
        //     return (int) $user->id === (int) $userId;
        // });
        
        require base_path('routes/channels.php');
    }
}
