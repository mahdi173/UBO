<?php

namespace App\Console\Commands;

use App\Services\WpUserService;
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
    public function handle(WpUserService $wpUserService): void
    {
        $wpUserService->getAllWpUsers_wordpress();   
    }
}
