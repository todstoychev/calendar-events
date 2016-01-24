<form action="{{ $action }}" method="post" xmlns="http://www.w3.org/1999/html">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    {{-- Title field --}}
    <label for="title">*{!! trans('calendar-events::calendar-events.title') !!}</label>
    <input name="title" type="text" placeholder="{!! trans('calendar-events::calendar-events.title') !!}" />
    <br />

    {{-- Description --}}
    <label for="description">{!! trans('calendar-events::calendar-events.description') !!}</label>
    <textarea name="description" placeholder="{!! trans('calendar-events::calendar-events.your_text_here') !!}" id="description"
    ></textarea>
    <br />

    {{-- All day check box --}}
    <label for="all-day">
        <input type="checkbox" name="all_day" value="true" id="all-day" onchange="CalendarEvents.allDayToggle();" />
        {!! trans('calendar-events::calendar-events.all_day') !!}
    </label>
    <br />

    {{-- Start date --}}
    <label for="start">*{!! trans('calendar-events::calendar-events.start') !!}</label>
    <input
            type="text"
            name="start[date]"
            placeholder="{!! trans('calendar-events::calendar-events.date') !!}"
            id="start"
    />
    -
    <input
            type="text"
            name="start[time]"
            placeholder="{!! trans('calendar-events::calendar-events.time') !!}"
            id="start-time"
    />
    <br />

    {{-- End date --}}
    <label for="end">{!! trans('calendar-events::calendar-events.end') !!}</label>
    <input
            type="text"
            name="end[date]"
            placeholder="{!! trans('calendar-events::calendar-events.end') !!}"
            id="end"
    />
    -
    <input
            type="text"
            name="end[time]"
            placeholder="{!! trans('calendar-events::calendar-events.time') !!}"
            id="end-time"
    />
    <br />

    <?php $colors = \Todstoychev\Wsc\Wsc::getColors(); ?>

    {{-- Border color --}}
    <label for="border-color">{!! trans('calendar-events::calendar-events.border_color') !!}</label>
    <select name="border_color" id="border-color">
        <option value="">{!! trans('calendar-events::calendar-events.select_color') !!}</option>
        @foreach($colors as $color)
        <option value="#{{ $color }}" style="background-color: #{{ $color }}">
            #{{ $color }}
        </option>
        @endforeach
    </select>
    <br />

    {{-- Background color --}}
    <label for="background-color">{!! trans('calendar-events::calendar-events.background_color') !!}</label>
    <select name="background_color" id="background-color">
        <option value="">{!! trans('calendar-events::calendar-events.select_color') !!}</option>
        @foreach($colors as $color)
        <option value="#{{ $color }}" style="background-color: #{{ $color }}">
            #{{ $color }}
        </option>
        @endforeach
    </select>
    <br />

    {{-- Text color --}}
    <label for="text-color">{!! trans('calendar-events::calendar-events.text_color') !!}</label>
    <select name="text_color" id="text-color">
        <option value="">{!! trans('calendar-events::calendar-events.select_color') !!}</option>
        @foreach($colors as $color)
        <option value="#{{ $color }}" style="background-color: #{{ $color }}">
            #{{ $color }}
        </option>
        @endforeach
    </select>
    <br />

    {{-- Reapeat event checkbox --}}
    <label for="repeat">
        <input type="checkbox" name="repeat" id="repeat" onchange="CalendarEvents.repeatEventToggle();" />
        {!! trans('calendar-events::calendar-events.repeat_event') !!}
    </label>
    <br />

    {{-- Repeat events block --}}
    <div id="repeat-event">
        @include('calendar-events::repeat-dates')
    </div>

    <input type="submit" value="{!! trans('calendar-events::calendar-events.save') !!}" />
</form>
