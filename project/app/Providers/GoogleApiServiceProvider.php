<?php

namespace App\Providers;

use Google\Client as GoogleClient;
use Illuminate\Support\ServiceProvider;

class GoogleApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleClient::class, function ($app) {
            $client = new GoogleClient();
            $client->setAuthConfig(storage_path('app/google/credentials.json'));
            $client->addScope([\Google_Service_Sheets::SPREADSHEETS, \Google_Service_Drive::DRIVE]);
            $client->setAccessType('offline');
            return $client;
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
