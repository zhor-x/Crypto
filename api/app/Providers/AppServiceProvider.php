<?php

namespace App\Providers;

use App\Services\NewsApiService;
 use Illuminate\Support\ServiceProvider;
use  GuzzleHttp\Client as guzzleClient;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $defaultOptions = [
            'base_uri' => config('app.news_url'),
            'timeout' => 10,
            'verify' => false,
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];
          $this->app->bind(NewsApiService::class, function () use ($defaultOptions) {
            return new NewsApiService(new guzzleClient($defaultOptions));
        });
    }

}
