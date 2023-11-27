<?php

namespace App\Providers;

use App\Services\GitHubService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GitHubService::class, function ($app) {
            $client = new Client();
            $config = Config::getFacadeRoot();
            return new GitHubService($client,$config);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
