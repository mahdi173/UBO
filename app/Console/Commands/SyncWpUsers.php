<?php

namespace App\Console\Commands;

use App\Actions\DeleteWpUsersAction;
use App\Actions\SendWpUsersAction;
use App\Actions\UpdateWpUsersAction;
use Illuminate\Console\Command;

class SyncWpUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:sync-wp-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command always transfers wp users that should be : created, updated and deleted';

    /**
     * Execute the console command.
     */
    public function handle(SendWpUsersAction $sendWpUsers, DeleteWpUsersAction $deleteWpUsers, UpdateWpUsersAction $updateWpUsers): void
    {
        $sendWpUsers();
        $deleteWpUsers();
        $updateWpUsers();
    }
}
