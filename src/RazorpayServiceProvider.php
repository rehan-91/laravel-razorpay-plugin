<?php

namespace RazorpayPlugin;

use Illuminate\Support\ServiceProvider;

class RazorpayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/razorpay.php', 'razorpay');
        $this->app->singleton(RazorpayService::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/razorpay.php');

        $this->publishes([
            __DIR__.'/../config/razorpay.php' => config_path('razorpay.php'),
        ], 'razorpay-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/razorpay-plugin'),
        ], 'razorpay-views');
    }
}
