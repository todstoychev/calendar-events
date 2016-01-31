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
        $start = strtotime($data['start']['date'] . ' ' . $data['start']['time']);
        $start = date('Y-m-d H:i:s', $start);
        $end = null;

        if (array_key_exists('end', $data)) {
            $end = strtotime($data['end']['date'] . ' ' . $data['end']['time']);
            $end = date('Y-m-d H:i:s', $end);
        }

        $event = [
            'title' => $data['title'],
            'description' => $data['description'],
            'start' => $start,
            'end' => $end,
            'all_day' => array_key_exists('all_day', $data),
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
        $allDay = array_key_exists('all_day', $data);

        foreach ($data['repeat_dates'] as $date) {
            $date = strtotime($date . ' ' . $data['start']['time']);

            if (false === $date) {
                throw new InvalidDateStringException('Invalid date string!');
            }

            $eventStart = $this->carbon->copy()->setTimestamp($date);
            $eventEnds = $allDay ? $eventStart->copy()->addSeconds($eventLength) : null;
            $dates[] = [
                'start' => $eventStart->toDateTimeString(),
                'end' => (null !== $eventEnds) ? $eventEnds->toDateTimeString() : null,
            ];
        }

        return $dates;
    }

    /**
     * Calculate event length in seconds
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