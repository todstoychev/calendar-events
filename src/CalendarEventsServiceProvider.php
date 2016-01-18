<?php

namespace Todstoychev\CalendarEvents;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider class
 *
 * @package Todstoychev\Calendar
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'calendar');

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'calendar');

        $this->publishes(
            [
                __DIR__ . '/../database/migrations/' => database_path('migrations/'),
                __DIR__ . '/../config/' => config_path('calendar/'),
            ]
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'calendar'
        );
    }
}
