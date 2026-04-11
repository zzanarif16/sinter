<?php

namespace App\Providers;

use App\Models\Contact;
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
        View::composer('components.layouts.site', function ($view): void {
            $footerContact = null;

            if (Schema::hasTable('contacts')) {
                $footerContact = Contact::query()->latest()->first();
            }

            $view->with('footerContact', $footerContact);
        });
    }
}
