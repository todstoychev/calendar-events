<label for="repeat-dates">{!! trans('calendar-events::calendar-events.repeat_dates') !!}</label>
@if(isset($calendarEvent) && $calendarEvent->calendarEventRepeatDates()->count() > 0)
    @foreach($calendarEvent->calendarEventRepeatDates() as $eventDate)
        <div class="repeat-date-field">
            <input
                    type="text"
                    name="repeat_dates[]"
                    placeholder="{!! trans('calendar-events::calendar-events.date') !!}"
                    id="repeat-dates"
                    value="{{ date('Y-m-d', strtotime($eventDate->start)) }}"
            />
            <button type="button" class="remove-field" onclick="CalendarEvents.removeField();">
                {!! trans('calendar-events::calendar-events.remove_field') !!}
            </button>
        </div>
    @endforeach
@else
<div class="repeat-date-field">
    <input
            type="text"
            name="repeat_dates[]"
            placeholder="{!! trans('calendar-events::calendar-events.date') !!}"
            id="repeat-dates"
    />
    <button type="button" class="remove-field" onclick="CalendarEvents.removeField();">
        {!! trans('calendar-events::calendar-events.remove_field') !!}
    </button>
</div>
@endif
<button id="add-repeat-date-field" type="button" onClick="CalendarEvents.addRepeatDateField();">
    {!! trans('calendar-events::calendar-events.add_date') !!}
</button>
