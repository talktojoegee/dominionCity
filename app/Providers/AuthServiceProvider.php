<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       /* Gate::define('owner',function(User $user){
            $permissions = Permission::all()->pluck('name')->toArray();
            $userRole = $user->roles->pluck('name');
            $rolePermissions = $userRole->permissions->pluck('name');
            if($user->hasRole == "owner" && $user->hasPermission == "permission-name"){
                return true;
            }
            return false;
        });*/
    }
}
