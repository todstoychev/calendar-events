<?php

namespace Todstoychev\CalendarEvents\Services;

use Todstoychev\CalendarEvents\Models\CalendarEvent;

/**
 * Calendar events service
 *
 * @package Todstoychev\CalendarEvents\Services
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEvents
{
    /**
     * @var CalendarEvent
     */
    protected $calendarEvent;

    public function __construct(CalendarEvent $calendarEvent)
    {
        $this->setCalendarEvent($calendarEvent);
    }

    /**
     * @return CalendarEvent
     */
    public function getCalendarEvent()
    {
        return $this->calendarEvent;
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return CalendarEvents
     */
    public function setCalendarEvent(CalendarEvent $calendarEvent)
    {
        $this->calendarEvent = $calendarEvent;

        return $this;
    }

    public function createEvent()
    {

    }

    public function updateEvent()
    {

    }

    public function deleteEvent()
    {

    }

    public function getEvents()
    {

    }

    public function getEvent()
    {

    }
}