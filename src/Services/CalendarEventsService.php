<?php

namespace Todstoychev\CalendarEvents\Services;

use Illuminate\Support\Facades\Cache;
use Todstoychev\CalendarEvents\Engine\CalendarEventsEngine;
use Todstoychev\CalendarEvents\Models;
use Todstoychev\CalendarEvents\Models\EventLocation;

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
     * @var Models\CalendarEventRepeatDate
     */
    protected $calendarEventRepeatDate;

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
     * All calendar events json string cache key
     */
    const ALL_EVENTS_TO_JSON_KEY = 'all_calendar_events_json';

    /**
     * @var int
     */
    protected $cacheTimeToLive;

    /**
     * @var Models\EventLocation
     */
    protected $eventLocation;

    /**
     * CalendarEventsService constructor.
     *
     * @param CalendarEventsEngine $calendarEventsEngine
     * @param Models\CalendarEvent $calendarEvent
     * @param Models\CalendarEventRepeatDate $calendarEventRepeatDate
     * @param Models\EventLocation $eventLocation
     * @param Cache $cache
     * @param int $cacheTimeToLive
     */
    public function __construct(
        CalendarEventsEngine $calendarEventsEngine,
        Models\CalendarEvent $calendarEvent,
        Models\CalendarEventRepeatDate $calendarEventRepeatDate,
        EventLocation $eventLocation,
        Cache $cache,
        $cacheTimeToLive = 10
    ) {
        $this->calendarEventsEngine = $calendarEventsEngine;
        $this->calendarEvent = $calendarEvent;
        $this->calendarEventRepeatDate = $calendarEventRepeatDate;
        $this->eventLocation = $eventLocation;
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
        $this->handleEventLocation($data, $calendarEvent);

        foreach ($eventDates as $date) {
            $calendarEventRepeatDate = clone $this->calendarEventRepeatDate;
            $calendarEventRepeatDate->start = $date['start'];
            $calendarEventRepeatDate->end = $date['end'];
            $calendarEventRepeatDate->calendarEvent()
                                    ->associate($calendarEvent)
            ;
            $calendarEventRepeatDate->save();
            unset($calendarEventRepeatDate);
        }

        $cache::put(self::CACHE_KEY.$calendarEvent->id, $calendarEvent, $this->cacheTimeToLive);
        $allEvents = $this->getAllEvents();
        $allEvents[$calendarEvent->id] = $calendarEvent;
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

        if ($cache::has(self::CACHE_KEY.$id)) {
            return $cache::get(self::CACHE_KEY.$id);
        }

        $calendarEvent = $this->calendarEvent
            ->with('calendarEventRepeatDates')
            ->where('id', $id)
            ->firstOrFail()
        ;

        $cache::put(self::CACHE_KEY.$id, $calendarEvent, $this->cacheTimeToLive);

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
            ->with('calendarEventRepeatDates')
            ->get()
        ;

        $calendarEvents = [];

        foreach ($allEvents as $event) {
            $calendarEvents[$event->id] = $event;
        }

        $cache::put(self::ALL_EVENTS_KEY, $calendarEvents, $this->cacheTimeToLive);

        return $calendarEvents;
    }

    /**
     * Get all events JSON
     *
     * @return string
     */
    public function getAllEventsAsJson()
    {
        $cache = $this->cache;

        if ($cache::has(self::ALL_EVENTS_TO_JSON_KEY)) {
            return $cache::get(self::ALL_EVENTS_TO_JSON_KEY);
        }

        $allEvents = $this->calendarEventsEngine->formatEventsToJson($this->getAllEvents());
        $allEventsToJson = json_encode($allEvents);
        $cache::put(self::ALL_EVENTS_TO_JSON_KEY, $allEventsToJson, $this->cacheTimeToLive);

        return $allEventsToJson;

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
        $calendarEventRepeatDate = clone $this->calendarEventRepeatDate;
        $calendarEventRepeatDate
            ->where('calendar_event_id', $id)
            ->delete()
        ;
        $this->calendarEvent
            ->where('id', $id)
            ->update($eventData)
        ;

        // This is necessary due to in some Laravel 5.1 versions there is no model hydration after update
        $calendarEvent = $this->calendarEvent
            ->where('id', $id)
            ->firstOrFail()
        ;
        $this->handleEventLocation($data, $calendarEvent);

        foreach ($eventDates as $date) {
            $calendarEventRepeatDate = clone $this->calendarEventRepeatDate;
            $calendarEventRepeatDate->start = $date['start'];
            $calendarEventRepeatDate->end = $date['end'];
            $calendarEventRepeatDate->calendarEvent()
                                    ->associate($calendarEvent)
            ;
            $calendarEventRepeatDate->save();
            unset($calendarEventRepeatDate);
        }

        $cache::put(self::CACHE_KEY.$calendarEvent->id, $calendarEvent, $this->cacheTimeToLive);
        $allEvents = $this->getAllEvents();
        $allEvents->put($calendarEvent->id, $calendarEvent);
        $cache::put(self::ALL_EVENTS_KEY, $allEvents, $this->cacheTimeToLive);

        return true;
    }

    /**
     * Handles EventLocation save/update
     *
     * @param array $data
     *
     * @param \Todstoychev\CalendarEvents\Models\CalendarEvent $calendarEvent
     *
     * @return null|\Todstoychev\CalendarEvents\Models\EventLocation
     */
    protected function handleEventLocation(array $data, Models\CalendarEvent $calendarEvent)
    {
        if (array_key_exists('longitude', $data) && !empty($data['longitude'])) {
            $this->eventLocation->longitude = $data['longitude'];
        }

        if (array_key_exists('latitude', $data) && !empty($data['latitude'])) {
            $this->eventLocation->latitude = $data['latitude'];
        }

        if (array_key_exists('address', $data) && !empty($data['address'])) {
            $this->eventLocation->address = $data['address'];
        }

        if (
            (!empty($this->eventLocation->longitude) && !empty($this->eventLocation->latitude)) ||
            !empty($this->eventLocation->address)
        ) {
            $this->eventLocation->calendarEvent()
                                ->associate($calendarEvent)
            ;
            $this->eventLocation->save();

            return $this->eventLocation;
        }

        return null;
    }
}