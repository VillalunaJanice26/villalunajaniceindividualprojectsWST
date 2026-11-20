<?php

namespace App\Providers;

use App\Models\Equipment;
use App\Models\User;
use App\Policies\V1\EquipmentPolicy;
use App\Policies\V1\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Equipment::class, EquipmentPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
