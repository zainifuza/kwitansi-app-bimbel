<?php

namespace App\Providers;

use App\Models\CompanySetting;
use Illuminate\Support\Facades\Schema;
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
        if (! Schema::hasTable('company_settings')) {
            return;
        }

        CompanySetting::query()->pluck('value', 'key')->each(function ($value, $key) {
            config()->set('company.' . $key, $value);
        });
    }
}
