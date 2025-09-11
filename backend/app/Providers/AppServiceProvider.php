<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RabbitMQPublisher;
use App\Console\Commands\RoadRunnerWorker;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RabbitMQPublisher::class, function ($app) {
            return new RabbitMQPublisher();
        });
    }

    public function boot(): void
    {
        $this->commands([
            RoadRunnerWorker::class,
        ]);
    }
}
