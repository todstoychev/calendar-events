<?php

namespace Todstoychev\CalendarEvents\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EventLocation
 *
 * @property string $longitude
 * @property string $latitude
 * @property string $address
 *
 * @package App
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class EventLocation extends Model
{
    /**
     * @var string
     */
    protected $table = 'event_locations';

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
