<?php

namespace Todstoychev\CalendarEvents\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Calendar event model
 *
 * @package Todstoychev\CalendarEvents\Models
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEvent extends Model
{
    /**
     * @var string
     */
    protected $table = 'calendar_events';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'all_day',
        'start',
        'end',
        'border_color',
        'background_color',
        'text_color'
    ];

    /**
     * CalendarEventDate relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendarEventDates()
    {
        return $this->hasMany('\Todstoychev\CalendarEvents\Models\CalendarEventDate', 'calendar_event_id', 'id');
    }
}
