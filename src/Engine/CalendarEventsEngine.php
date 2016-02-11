<?php

namespace Todstoychev\CalendarEvents\Engine;

use Carbon\Carbon;
use Todstoychev\CalendarEvents\Exceptions\DateDifferenceException;
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

            if (strtotime($end) < strtotime($start)) {
                throw new DateDifferenceException('Start date bigger then end date!');
            }
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
            if (strlen($date) > 0) {
                $date = strtotime($date . ' ' . $data['start']['time']);

                if (false === $date) {
                    throw new InvalidDateStringException('Invalid date string!');
                }

                $eventStart = $this->carbon->copy()->setTimestamp($date);
                $eventEnds = $allDay ? null : $eventStart->copy()->addSeconds($eventLength);
                $dates[] = [
                    'start' => $eventStart->toDateTimeString(),
                    'end' => (null !== $eventEnds) ? $eventEnds->toDateTimeString() : null,
                ];
            }
        }

        return $dates;
    }

    /**
     * Creates JSON string from events collection
     *
     * @param array $calendarEvents
     *
     * @return array
     */
    public function formatEventsToJson(array $calendarEvents)
    {
        $array = [];

        foreach ($calendarEvents as $event) {
            $start = $this->carbon
                ->copy()
                ->setTimestamp(strtotime($event->start))
                ->toIso8601String();
            $end = $this->carbon
                ->copy()
                ->setTimestamp(strtotime($event->end))
                ->toIso8601String();
            $allDay = $event->all_day == 1;

            $data = [
                'title' => $event->title,
                'description' => $event->description,
                'start' => $start,
                'end' => $end,
                'allDay' => $allDay,
                'borderColor' => $event->border_color,
                'textColor' => $event->text_color,
                'backgroundColor' => $event->background_color,
            ];

            $array[] = $data;

            if ($event->calendarEventRepeatDates()->count() > 0) {
                foreach ($event->calendarEventRepeatDates()->get() as $repeatDate) {
                    $start = $this->carbon
                        ->copy()
                        ->setTimestamp(strtotime($repeatDate->start))
                        ->toIso8601String();
                    $end = $this->carbon
                        ->copy()
                        ->setTimestamp(strtotime($repeatDate->end))
                        ->toIso8601String();

                    $data['start'] = $start;
                    $data['end'] = $end;

                    $array[] = $data;
                }
            }
        }

        return $array;
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