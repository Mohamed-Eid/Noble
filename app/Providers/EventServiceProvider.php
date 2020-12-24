<?php

namespace App\Providers;

use App\Events\NewProductHasOrdered;
use App\Events\OrderStatusHasChanged;
use App\Listeners\NotifyTheAdmin;
use App\Listeners\NotifyTheClient;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewProductHasOrdered::class => [
            NotifyTheAdmin::class,
        ],
        
        OrderStatusHasChanged::class => [
            NotifyTheClient::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
