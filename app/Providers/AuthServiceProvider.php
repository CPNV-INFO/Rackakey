<?php

namespace App\Providers;

use App\Policies\UsbPolicy;
use App\Policies\UserPolicy;
use App\Role;
use App\Usb;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Usb::class => UsbPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // https://laravel.com/docs/5.7/authorization#intercepting-gate-checks --> Grant admin all policies
        Gate::before(function ($user, $ability) {
            if ($user->role->id == Role::admin())
                return true;
        });

        Gate::resource('usbs', 'App\Policies\UsbPolicy');
//        Gate::define('viewReservedFrom','App\Policies\UserPolicy@viewReservedFrom');
//        Gate::define('viewActionColumn',   'App\Policies\UserPolicy@viewActionColumn');
        Gate::define('viewSoftDelete',   'App\Policies\UserPolicy@viewSoftDelete');
    }
}
