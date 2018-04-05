<?php

namespace QuadStudio\Bot;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Routing\Router;
use QuadStudio\Bot\Http\Middleware\VerifyBot;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {

        // Load config
        $this->mergeConfigFrom(
            $this->packagePath('config/bot.php'), 'bot'
        );

    }

    private function packagePath($path)
    {
        return __DIR__ . "/../{$path}";
    }

    public function boot(Router $router)
    {

        // Load translations
        $this->loadTranslationsFrom($this->packagePath('resources/lang'), 'bot');

        // Publish translations
        $this->publishes([
            $this->packagePath('config/bot.php') => config_path('bot.php'),
        ], 'config');

        // Publish config
        $this->publishes([
            $this->packagePath('resources/lang') => resource_path('lang/vendor/bot'),
        ], 'translations');

        // Register middleware
        $router->aliasMiddleware('auth.bot', VerifyBot::class);

    }

}