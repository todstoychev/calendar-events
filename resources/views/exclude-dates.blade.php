<label for="exclude-dates">
    {!! trans('calendar-events::calendar-events.exclude_dates') !!}
</label>
<div class="exclude-date-field">
    <input
            type="text"
            name="exclude_dates[]"
            placeholder="{!! trans('calendar-events::calendar-events.date') !!}"
            id="exclude-dates"
    />
</div>
<button type="button" id="add-exclude-date-field" onclick="CalendarEvents.addExcludeDateField();">
    {!! trans('calendar-events::calendar-events.add_date') !!}
</button>
