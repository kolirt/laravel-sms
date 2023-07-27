<?php

namespace Kolirt\Sms;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceProvider extends BaseServiceProvider
{
    protected $commands = [
        Commands\InstallCommand::class
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/sms.php' => config_path('sms.php')
        ]);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sms.php', 'sms');
        $this->commands($this->commands);

        app()->bind('sms', function(){
            return new Sms;
        });
    }
}