<?php

namespace Todstoychev\CalendarEvents\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EventLocation
 *
 * @package App
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class EventLocation extends Model
{
    /**
     * @var string
     */
    protected $table = 'events_locations';

    /**
     * @var array
     */
    protected $fillable = [
        'longitude',
        'latitude',
        'address',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendarEvent()
    {
        return $this->belongsTo(CalendarEvent::class, 'calendar_event_id', 'id');
    }
}
