[![Build Status](https://travis-ci.org/todstoychev/calendar-events.svg?branch=master)](https://travis-ci.org/todstoychev/calendar-events)

Laravel 5 module to integrate a [fullcalendar](http://fullcalendar.io/) javascript plugin. It provides simple way to store events in the database and supports event repeat.

# Installation
Use the standart way ```composer require todstoychev/calendar-events```.

Register the service provider at your Laravel ```config/app.php```. You should add ```Todstoychev\CalendarEvents\CalendarEventsServiceProvider::class```.

Run ```php artisan vendor:publish``` to publish config and other assets.

This module provides also 2 migration files. It will be necessary to run them ```php artisan migrate```.

# Usage

## Forms
This module comes with a ready to use form template. The form can be used as edit and add form. In your blade use ```@include('calendar-events::form')``` to include it in your page. Also feel free to override and extend this template.

To use this form add to your page you will need a javascript file provided from the module. After running vendor publish command you should be able to find ```public/js/calendar-events.js```. This script is necessary to control provided form. It contains simple JS object with few methods inside. 

## Controller
Since this module has service provider at the container, you can access CalendarEventsService::class in your controller like this:

```php
protected $calendarEventsService;

    public function __construct(CalendarEventsService $calendarEventsService)
    {
        $this->calendarEventsService = $calendarEventsService;
    }
```

This the main module class that contains all the necessary methods to interact with.

Module provides a request class which can be used to validate your input data. Here an example usage of how to create new event.

```php
<?php

namespace App\Http\Controllers;

use Todstoychev\CalendarEvents\Http\Requests\CalendarEventRequest;
use Todstoychev\CalendarEvents\Services\CalendarEventsService;

class IndexController extends Controller
{
    protected $calendarEventsService;

    public function __construct(CalendarEventsService $calendarEventsService)
    {
        $this->calendarEventsService = $calendarEventsService;
    }

    public function postAdd(CalendarEventRequest $request)
    {
        $this->calendarEventsService->createCalendarEvent($request->input());
    }
}
```

The service class has methods to provide fully functional crud. To update event you can use ```CalendarEventsService::updateCalendarEvent()```.
 To get a single event use ```CalendarEventsService::getCalendarEvent()```.
 ```CalendarEventsService::getAllEvents()``` will fetch all calendar events.
 The most important method is probably ```CalendarEventsService::getAllEventsToJson()```. This one should be used with the javascript plugin. The method provides the necessary json string. Here example of usage. In your controller create a method like this one:

```php
     public function getJson()
     {
         echo $this->calendarEventsService->getAllEventsAsJson();
     }
```

This one should be used with fullcalendar like this:
 
```html
<div id="calendar"></div>
<script src="{{ asset('jquery.js') }}"></script>
<script src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
<script>
    $(document).ready(function () {
        CalendarEvents.init();
        $('#calendar').fullCalendar({
            eventSources: [
                {
                    url: 'http://example.com/json'
                }
            ]
        });
    });
</script>
```

# TODO
- Add more PHPUnit test to achieve maximum coverage.
- Create Bootstrap 3 compatible templates for the form.
- Add functionality to repeat event each week, month and year.
- Add functionality to select weekdays on which event will be repeated.
- Add functionality to repeat event after number of days.
- Add functionality to repeat event certain times.