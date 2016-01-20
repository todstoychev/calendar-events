<label for="include-dates">{!! trans('calendar-events::calendar-events.include_dates') !!}</label>
<div class="include-date-field">
    <input
            type="text"
            name="include_dates[]"
            placeholder="{!! trans('calendar-events::calendar-events.date') !!}"
            id="include-dates"
    />
</div>
<button id="add-include-date-field" type="button" onClick="CalendarEvents.addIncludeDateField();">
    {!! trans('calendar-events::calendar-events.add_date') !!}
</button>
