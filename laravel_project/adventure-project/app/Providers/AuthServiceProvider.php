<?php

namespace App\Providers;

use App\Models\Adventure;
use App\Models\Booking;
use App\Policies\AdventurePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Adventure::class => AdventurePolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
