<label for="repeat_type">{!! trans('calendar-events::calendar-events.repeat_type') !!}</label>
<select name="repeat_type">
    <option value="">{!! trans('calendar-events::calendar-events.select_repeat_type') !!}</option>
    <option value="annual">{!! trans('calendar-events::calendar-events.annual') !!}</option>
    <option value="monthly">{!! trans('calendar-events::calendar-events.monthly') !!}</option>
    <option value="on2weeks">{!! trans('calendar-events::calendar-events.on2weeks') !!}</option>
    <option value="weekly">{!! trans('calendar-events::calendar-events.weekly') !!}</option>
    <option value="daily">{!! trans('calendar-events::calendar-events.daily') !!}</option>
</select>
<br />

{{-- Select days to repeat on --}}
<label for="weekdays">
    <input type="checkbox" name="weekdays" id="weekdays" />
    {!! trans('calendar-events::calendar-events.repeat_on_weekdays') !!}
</label>
<br />

{{-- Select week days --}}
<div id="repeat-at">
    <label for="monday">
        <input type="checkbox" name="repeat_at[monday]" id="monday" />
        {!! trans('calendar-events::calendar-events.monday') !!}
    </label>

    <label for="tuesday">
        <input type="checkbox" name="repeat_at[tuesday]" id="tuesday" />
        {!! trans('calendar-events::calendar-events.tuesday') !!}
    </label>

    <label for="wednesday">
        <input type="checkbox" name="repeat_at[wednesday]" id="wednesday" />
        {!! trans('calendar-events::calendar-events.wednesday') !!}
    </label>

    <label for="thursday">
        <input type="checkbox" name="repeat_at[thursday]" id="thursday" />
        {!! trans('calendar-events::calendar-events.thursday') !!}
    </label>

    <label for="friday">
        <input type="checkbox" name="repeat_at[friday]" id="friday" />
        {!! trans('calendar-events::calendar-events.friday') !!}
    </label>

    <label for="saturday">
        <input type="checkbox" name="repeat_at[saturday]" id="saturday" />
        {!! trans('calendar-events::calendar-events.saturday') !!}
    </label>

    <label for="sunday">
        <input type="checkbox" name="repeat_at[sunday]" id="sunday" />
        {!! trans('calendar-events::calendar-events.sunday') !!}
    </label>
</div>

{{-- Exclude dates checkbox --}}
<label for="exclude-dates">
    <input type="checkbox" name="exclude_dates" id="exclude-dates" />
    {!! trans('calendar-events::calendar-events.exclude_dates') !!}
</label>
<br />

{{-- Exclude date --}}
<div id="exclude-dates-block">
    @include('calendar-events::exclude-dates')
</div>

{{-- Include dates checkbox --}}
<label for="include-dates">
    <input type="checkbox" name="include_dates" id="include-dates" />
    {!! trans('calendar-events::calendar-events.include_dates') !!}
</label>
<br />

{{-- Include dates --}}
<div id="include-dates-block">
    @include('calendar-events::include-dates')
</div>

{{-- Stop repeat at date --}}
<label for="stop-repeat-at">{!! trans('calendar-events::calendar-events.stop_repeat_at') !!}</label>
<input type="text" name="stop_repeat_at" placeholder="{!! trans('calendar-events::calendar-events.date') !!}" id="stop-repeat-at" />
<br />

{{-- Repeat times --}}
<label for="repeat-times">{!! trans('calendar-events::calendar-events.repeat_times') !!}</label>
<input type="text" name="repeat_times" placeholder="{!! trans('calendar-events::calendar-events.repeat_times') !!}" id="repeat-times" />