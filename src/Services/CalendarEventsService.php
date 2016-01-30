<?php

namespace Todstoychev\CalendarEvents\Services;

use Illuminate\Support\Facades\Cache;
use Todstoychev\CalendarEvents\Engine\CalendarEventsEngine;
use Todstoychev\CalendarEvents\Models;

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
     * @var Models\CalendarEvent
     */
    protected $calendarEvent;

    /**
     * @var Models\CalendarEventDate
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

    /**
     * CalendarEventsService constructor.
     *
     * @param CalendarEventsEngine $calendarEventsEngine
     * @param Models\CalendarEvent $calendarEvent
     * @param Models\CalendarEventDate $calendarEventDate
     * @param Cache $cache
     * @param int $cacheTimeToLive
     */
    public function __construct(
        CalendarEventsEngine $calendarEventsEngine,
        Models\CalendarEvent $calendarEvent,
        Models\CalendarEventDate $calendarEventDate,
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
        $allEvents = $this->getAllEvents();
        $allEvents->put($calendarEvent->id, $calendarEvent);
        $cache::put(self::ALL_EVENTS_KEY, $allEvents, $this->cacheTimeToLive);

        return true;
    }

    /**
     * Gets an calendar event based on id
     *
     * @param int $id
     *
     * @return Models\CalendarEvent
     */
    public function getCalendarEvent($id)
    {
        /** @var Models\CalendarEvent $calendarEvent */
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

        $allEvents = $this->calendarEvent
            ->with('calendarEventDates')
            ->get();

        $calendarEvents = [];

        foreach ($allEvents as $event) {
            $calendarEvents[$event->id] = $event;
        }

        $cache::put(self::ALL_EVENTS_KEY, $calendarEvents, $this->cacheTimeToLive);

        return $calendarEvents;
    }

    /**
     * Deletes an calendar event and rebuilds the cache.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteCalendarEvent($id)
    {
        $cache = $this->cache;

        $this->calendarEvent->destroy($id);

        $allEvents = $this->getAllEvents();
        unset($allEvents[$id]);
        $cache::put(self::ALL_EVENTS_KEY, $allEvents, $this->cacheTimeToLive);

        return true;
    }

    /**
     * Updates an calendar event
     *
     * @param int $id
     * @param array $data
     *
     * @return bool
     */
    public function updateCalendarEvent($id, array $data)
    {
        $eventData = $this->calendarEventsEngine->buildEventData($data);
        $eventDates = $this->calendarEventsEngine->buildEventDates($data);
        $cache = $this->cache;
        $this->calendarEventDate
            ->where('calendar_event_id', $id)
            ->delete();
        $calendarEvent = $this->calendarEvent
            ->where('id', $id)
            ->update($eventData)
            ->save();

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
        $allEvents = $this->getAllEvents();
        $allEvents->put($calendarEvent->id, $calendarEvent);
        $cache::put(self::ALL_EVENTS_KEY, $allEvents, $this->cacheTimeToLive);

        return true;
    }
}