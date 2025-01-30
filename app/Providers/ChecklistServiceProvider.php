<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ChecklistService;

class ChecklistServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ChecklistService::class, function ($application) {
            return new ChecklistService();
        });
    }

    public function boot()
    {
        //
    }
}
