<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateOfflineUsers extends Command
{
    protected $signature = 'users:update-offline';
    protected $description = 'Update users who are offline based on session inactivity';

    public function handle()
    {
        $inactiveThreshold = now()->subMinutes(config('session.lifetime'));

        User::where('updated_at', '<', $inactiveThreshold) // Assuming "updated_at" reflects activity
            ->update(['is_online' => 0]);

        $this->info('Offline users updated successfully.');
    }
}
