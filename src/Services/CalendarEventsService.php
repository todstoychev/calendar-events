<?php

namespace Todstoychev\CalendarEvents\Services;

use Todstoychev\CalendarEvents\Models\CalendarEvent;

/**
 * Calendar events service
 *
 * @package Todstoychev\CalendarEvents\Services
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventsService
{
    /**
     * @var CalendarEvent
     */
    protected $calendarEvent;

    /**
     * @var array
     */
    protected $data;

    public function __construct(CalendarEvent $calendarEvent, array $data)
    {
        $this->setCalendarEvent($calendarEvent);
        $this->setData($data);
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

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return CalendarEventsService
     */
    public function setData(array $data)
    {
        $this->data = $data;

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

    protected function validateData()
    {

    }
}