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
        'border_color',
        'background_color',
        'text_color'
    ];

    /**
     * CalendarEventDate relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repeatDates()
    {
        return $this->hasMany('\Todstoychev\CalendarEvents\Models\RepeatDates', 'calendar_event_id', 'id');
    }
}
