<?php

namespace Todstoychev\CalendarEvents\Engine;

use Carbon\Carbon;
use Todstoychev\CalendarEvents\Exceptions\InvalidDateStringException;

/**
 * Calendar events engine. Calculates repeat dates and event length.
 *
 * @package Todstoychev\CalendarEvents\Engine
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventsEngine
{
    /**
     * @var Carbon
     */
    protected $carbon;

    /**
     * CalendarEventsEngine constructor.
     *
     * @param Carbon $carbon
     */
    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }

    /**
     * Builds event data
     *
     * @param array $data
     *
     * @return array
     */
    public function buildEventData(array $data)
    {
        $event = [
            'title' => $data['title'],
            'description' => $data['description'],
            'border_color' => $data['border_color'],
            'background_color' => $data['background_color'],
            'text_color' => $data['text_color'],
        ];

        return $event;
    }

    /**
     * Builds event dates array
     *
     * @param array $data
     *
     * @return array
     */
    public function buildEventDates(array $data)
    {
        $dates = [];
        $eventLength = $this->calculateEventLength($data);
        $allDay = array_key_exists('all_day', $data) ? true : false;
        $eventStart = $this->carbon->copy()->setTimestamp(strtotime($data['start']['date'] . ' ' . $data['start']['time']));
        $eventEnds = $eventStart->copy()->addSeconds($eventLength);
        $dates[] = [
            'start' => $eventStart->toDateTimeString(),
            'end' => $eventEnds->toDateTimeString(),
            'all_day' => $allDay,
        ];

        foreach ($data['repeat_dates'] as $date) {
            $date = date('Y-m-d', strtotime($date));

            if (false === $date) {
                throw new InvalidDateStringException('Invalid date string!');
            }

            $eventStart = $this->carbon->copy()->setTimestamp(strtotime($date . ' ' . $data['start']['time']));
            $eventEnds = $eventStart->copy()->addSeconds($eventLength);
            $dates[] = [
                'start' => $eventStart->toDateTimeString(),
                'end' => $eventEnds->toDateTimeString(),
                'all_day' => $allDay,
            ];
        }

        return $dates;
    }

    /**
     * Calculate event length in minutes
     *
     * @param array $data
     *
     * @return int
     */
    protected function calculateEventLength(array $data)
    {
        $start = $this->carbon->copy()->setTimestamp(strtotime($data['start']['date'] . ' ' . $data['start']['time']));

        if (array_key_exists('all_day', $data)) {
            $end = $this->carbon->copy()->setTimestamp(strtotime($data['start']['date'] . ' 23:59:59'));
        } else {
            $end = $this->carbon->copy()->setTimestamp(strtotime($data['start']['date'] . ' ' . $data['end']['time']));
        }

        return $start->diffInSeconds($end);
    }
}