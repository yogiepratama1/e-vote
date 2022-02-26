<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Builder::macro('search', function ($field, $string) {
        //     return $string ? $this->where($field, 'like', '%' . $string . '%') : $this;
        // });
        Paginator::useBootstrap();

        Gate::define('admin', function (User $user) {
            return $user->isAdmin == '1';
        });
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setlocale(LC_ALL, 'id_IND');
        date_default_timezone_set('Asia/Jakarta');
    }
}
