<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FirebaseAuthenticationService;

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
      $this->app->bind('App\Services\FirebaseAuthenticationService', function () {
        return new FirebaseAuthenticationService();
      });
    }
}
