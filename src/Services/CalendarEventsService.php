<?php

namespace Todstoychev\CalendarEvents\Services;

use Illuminate\Support\Facades\Cache;
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

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * Cache key
     */
    const CACHE_KEY = 'calendar_event_';

    /**
     * All calendar events cache key
     */
    const ALL_EVENTS_KEY = 'all_calendar_events';

    /**
     * @var int
     */
    protected $cacheTimeToLive;

    public function __construct(
        CalendarEventsEngine $calendarEventsEngine,
        CalendarEvent $calendarEvent,
        CalendarEventDate $calendarEventDate,
        Cache $cache,
        $cacheTimeToLive = 10
    ) {
        $this->calendarEventsEngine = $calendarEventsEngine;
        $this->calendarEvent = $calendarEvent;
        $this->calendarEventDate = $calendarEventDate;
        $this->cache = $cache;
        $this->cacheTimeToLive = $cacheTimeToLive;
    }

    /**
     * @param int $cacheTimeToLive
     *
     * @return $this
     */
    public function setCacheTimeToLive($cacheTimeToLive)
    {
        $this->cacheTimeToLive = $cacheTimeToLive;

        return $this;
    }

    /**
     * Creates calendar event
     *
     * @param array $data
     *
     * @return bool
     */
    public function createCalendarEvent(array $data)
    {
        $eventData = $this->calendarEventsEngine->buildEventData($data);
        $eventDates = $this->calendarEventsEngine->buildEventDates($data);
        $cache = $this->cache;
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

        $cache::put(self::CACHE_KEY . $calendarEvent->id, $calendarEvent, $this->cacheTimeToLive);

        return true;
    }

    /**
     * Gets an calendar event based on id
     *
     * @param int $id
     *
     * @return CalendarEvent
     */
    public function getCalendarEvent($id)
    {
        /** @var CalendarEvent $calendarEvent */
        $calendarEvent = null;

        $cache = $this->cache;

        if ($cache::has(self::CACHE_KEY . $id)) {
            return $cache::get(self::CACHE_KEY . $id);
        }

        $calendarEvent = $this->calendarEvent
            ->with('calendarEventDates')
            ->where('id', $id)
            ->firstOrFail();

        $cache::put(self::CACHE_KEY . $id, $calendarEvent, $this->cacheTimeToLive);

        return $calendarEvent;
    }

    /**
     * Gets all calendar events
     *
     * @return \Illuminate\Database\Eloquent\Collection|null|static[]
     */
    public function getAllEvents()
    {
        $calendarEvents = null;
        $cache = $this->cache;

        if ($cache::has(self::ALL_EVENTS_KEY)) {
            return $cache::get(self::ALL_EVENTS_KEY);
        }

        $calendarEvents = $this->calendarEvent
            ->with('calendarEventDates')
            ->get();

        $cache::put(self::ALL_EVENTS_KEY, $calendarEvents, $this->cacheTimeToLive);

        return $calendarEvents;
    }
}