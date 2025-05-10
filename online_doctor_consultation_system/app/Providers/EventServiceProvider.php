<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
protected $listen = [
        // ...
    ];
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        parent::boot();
    }
}
