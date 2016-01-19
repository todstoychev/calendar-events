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
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'calendar-events');

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'calendar-events');

        $this->publishes(
            [
                __DIR__ . '/../database/migrations/' => database_path('migrations/'),
                __DIR__ . '/../config/' => config_path('calendar-events/'),
                __DIR__ . '/../resources/lang/' =>base_path('resources/lang/'),
                __DIR__ . '/../resources/views/' => base_path('resources/vendor/calendar-events/'),
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
            __DIR__ . '/../config/config.php', 'calendar-events'
        );
    }
}
