<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;



namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateOnlineStatus
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $user->update(['is_online' => 1]);
    }
}
