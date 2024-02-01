<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate; //add
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/';
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
        //
        Paginator::useBootstrap();

        Gate::define('admin', function ($user) {
            if ($user->role_id == User::ADMIN_ROLE_ID) {
                // return Response::allow(); 今はもう使えない
                return true;
            } else {
                // return Response::deny('YOU MUST BE AN ADMINISTRATOR');　今はもう使えない
                return false;
            }
        });
    }
}
