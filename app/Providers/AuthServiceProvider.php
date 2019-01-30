<?php

namespace App\Providers;

use App\Policies\UsbPolicy;
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

        Gate::define('viewSoftDelete',              'App\Policies\UsbPolicy@viewSoftDelete');
        Gate::define('viewDeleteUsbButton',         'App\Policies\UsbPolicy@viewDeleteUsbButton');
        Gate::define('viewDownloadUsbDataButton',   'App\Policies\UsbPolicy@viewDownloadUsbDataButton');
        Gate::define('viewExploreUsbButton',        'App\Policies\UsbPolicy@viewExploreUsbButton');
        Gate::define('viewInitializeUsbButton',     'App\Policies\UsbPolicy@viewInitializeUsbButton');
    }
}
