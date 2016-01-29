<?php

namespace Todstoychev\CalendarEvents\Services;

use Todstoychev\CalendarEvents\Engine\CalendarEventsEngine;

/**
 * Calendar events service
 *
 * @package Todstoychev\CalendarEvents\Services
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventsService
{
    /**
     * @var CalendarEventsEngine
     */
    protected $calendarEventsEngine;

    public function __construct(CalendarEventsEngine $calendarEventsEngine)
    {
        $this->calendarEventsEngine = $calendarEventsEngine;
    }
}