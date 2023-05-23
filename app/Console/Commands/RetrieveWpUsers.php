<?php

namespace App\Console\Commands;

use App\Actions\RetrieveWpUsersAction;
use Illuminate\Console\Command;

class RetrieveWpUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:retrieve-wp-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve wp users daily';

    /**
     * Execute the console command.
     */
    public function handle(RetrieveWpUsersAction $retrieveWpUsers): void
    {
        $retrieveWpUsers();
    }
}
