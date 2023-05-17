<?php

namespace App\Providers;

use App\Models\Pole;
use App\Models\Role;
use App\Models\Type;
use App\Models\User;
use App\Models\WpRole;
use App\Models\WpSite;
use App\Models\WpUser;
use App\Observers\PoleObserver;
use App\Observers\RoleObserver;
use App\Observers\TypeObserver;
use App\Observers\UserObserver;
use App\Observers\WpRoleObserver;
use App\Observers\WpSiteObserver;
use App\Observers\WpUserObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        WpUser::observe(WpUserObserver::class);
        WpSite::observe(WpSiteObserver::class);
        WpRole::observe(WpRoleObserver::class);
        Pole::observe(PoleObserver::class);
        Role::observe(RoleObserver::class);
        Type::observe(TypeObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
