<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrapFive();

        View::composer('*', function ($view): void {
            try {
                $settings = Schema::hasTable('site_settings') ? SiteSetting::current() : new SiteSetting;
            } catch (\Throwable) {
                $settings = new SiteSetting;
            }

            $view->with('siteSettings', $settings);
            $view->with('siteLogoUrl', $settings->logo_path ? asset('storage/'.$settings->logo_path) : asset('assets/logo-gpa.jpg'));
        });
    }
}
