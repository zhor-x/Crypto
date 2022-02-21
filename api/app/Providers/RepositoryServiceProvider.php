<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Interfaces\ContentInterface', 'App\Repositories\ContentRepository');
        $this->app->bind('App\Interfaces\ContentSourceInterface', 'App\Repositories\ContentSourceRepository');
    }
}
