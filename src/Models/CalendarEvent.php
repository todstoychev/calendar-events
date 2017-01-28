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
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'all_day',
        'border_color',
        'background_color',
        'text_color'
    ];

    /**
     * CalendarEventDate relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendarEventRepeatDates()
    {
        return $this->hasMany(CalendarEventRepeatDate::class);
    }
}
