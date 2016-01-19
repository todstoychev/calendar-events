<?php

namespace Todstoychev\CalendarEvents\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * RepeatDates model
 *
 * @package Todstoychev\CalendarEvents\Models
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class RepeatDate extends Model
{
    /**
     * @var string
     */
    protected $table = 'repeat_dates';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * CalendarEvents relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendarEvent()
    {
        return $this->belongsTo('\Todstoychev\CalendarEvents\Models\CalendarEvent', 'calendar_event_id');
    }
}