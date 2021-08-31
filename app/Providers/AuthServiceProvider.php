<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Define user roles

        /* define a Master Admin user role */
        Gate::define('sys_admin', function($user) {
            return $user->user_type == 'sys_admin';
         });
        
         /* define a District Admin user role */
         Gate::define('dist_admin', function($user) {
             return $user->user_type == 'dist_admin';
         });

         /* define a Division Admin user role */
         Gate::define('divi_admin', function($user) {
            return $user->user_type == 'divi_admin';
        });

        Gate::define('branch_head', function($user) {
            return $user->user_type == 'branch_head';
        });
       
         /* define a user role */
         Gate::define('user', function($user) {
             return $user->user_type == 'user';
         });

         
    }
}
