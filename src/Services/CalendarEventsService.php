<?php

namespace Todstoychev\CalendarEvents\Services;

use Todstoychev\CalendarEvents\Engine\CalendarEventsEngine;
use Todstoychev\CalendarEvents\Models\CalendarEvent;
use Todstoychev\CalendarEvents\Models\CalendarEventDate;

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

    /**
     * @var CalendarEvent
     */
    protected $calendarEvent;

    /**
     * @var CalendarEventDate
     */
    protected $calendarEventDate;

    public function __construct(
        CalendarEventsEngine $calendarEventsEngine,
        CalendarEvent $calendarEvent,
        CalendarEventDate $calendarEventDate
    ) {
        $this->calendarEventsEngine = $calendarEventsEngine;
        $this->calendarEvent = $calendarEvent;
        $this->calendarEventDate = $calendarEventDate;
    }

    /**
     * Creates calendar event
     *
     * @param array $data
     */
    public function createCalendarEvent(array $data)
    {
        $eventData = $this->calendarEventsEngine->buildEventData($data);
        $eventDates = $this->calendarEventsEngine->buildEventDates($data);

        $calendarEvent = $this->calendarEvent->create($eventData);

        foreach ($eventDates as $date) {
            $calendarEventDate = clone $this->calendarEventDate;
            $calendarEventDate->start = $date['start'];
            $calendarEventDate->end = $date['end'];
            $calendarEventDate->all_day = $date['all_day'];
            $calendarEventDate->calendarEvent()->associate($calendarEvent);
            $calendarEventDate->save();
            unset($calendarEventDate);
        }
    }
}