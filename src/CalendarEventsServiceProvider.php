<?php

namespace Todstoychev\CalendarEvents;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Todstoychev\CalendarEvents\Engine\CalendarEventsEngine;
use Todstoychev\CalendarEvents\Models;
use Todstoychev\CalendarEvents\Services\CalendarEventsService;

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
        $this->publishes(
            [
                __DIR__ . '/../database/migrations' => database_path('/migrations'),
                __DIR__ . '/../config/calendar_events.php' => config_path('calendar_events.php'),
                __DIR__ . '/../resources/lang' => base_path('/resources/lang'),
                __DIR__ . '/../resources/views' => base_path('/resources/vendor/calendar-events'),
                __DIR__ . '/../public/js' => public_path('/js'),
            ]
        );

        Validator::extend('time', '\Todstoychev\CalendarEvents\Validator\CalendarEventsValidator@validateTime');
        Validator::extend(
            'dates_array',
            '\Todstoychev\CalendarEvents\Validator\CalendarEventsValidator@validateDatesArray'
        );

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'calendar-events');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'calendar_events_engine',
            function () {
                return new CalendarEventsEngine(new Carbon());
            }
        );

        $this->app->bind(
            'calendar_events_service',
            function () {
                new CalendarEventsService(
                    $this->app->make('calendar_events_engine'),
                    new Models\CalendarEvent(),
                    new Models\CalendarEventRepeatDate(),
                    new Cache()
                );
            }
        );
    }
}
