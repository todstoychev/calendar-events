<?php

namespace Todstoychev\CalendarEvents\Models;

/**
 * Calendar events dates
 *
 * @package Todstoychev\CalendarEvents\Models
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventDate
{
    /**
     * @var string
     */
    protected $table = 'calendar_events_dates';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        'start',
        'end',
        'all_day'
    ];

    /**
     * CalendarEvent relation
     *
     * @return CalendarEvent
     */
    public function calendarEvent()
    {
        return $this->belongsTo('\Todstoychev\CalendarEvents\Models\CalendarEvent', 'calendar_event_id');
    }
}