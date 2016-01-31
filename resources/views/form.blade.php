@if(isset($calendarEvent))
    <form action="{{ $action }}" method="PUT">
@else
    <form action="{{ $action }}" method="POST">
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    {{-- Title field --}}
    <label for="title">*{!! trans('calendar-events::calendar-events.title') !!}</label>
    <input
            name="title"
            type="text"
            placeholder="{!! trans('calendar-events::calendar-events.title') !!}"
            value="{{ isset($calendarEvent) ? $calendarEvent->title : null }}"
    />
    <br />

    {{-- Description --}}
    <label for="description">{!! trans('calendar-events::calendar-events.description') !!}</label>
    <textarea
            name="description"
            placeholder="{!! trans('calendar-events::calendar-events.your_text_here') !!}"
            id="description"
    >
        {{ isset($calendarEvent) ? $calendarEvent->description : null }}
    </textarea>
    <br />

    {{-- All day check box --}}
    <label for="all-day">
        <input
                type="checkbox"
                name="all_day"
                value="true"
                id="all-day" onchange="CalendarEvents.allDayToggle();"
                {{ (isset($calendarEvent) && true === $calendarEvent->all_day) ? 'checked=\"\"' : null }}
        />
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
            value="{{ isset($calendarEvent) ? date('Y-m-d', strtotime($calendarEvent->start)) : null }}"
    />
    -
    <input
            type="text"
            name="start[time]"
            placeholder="{!! trans('calendar-events::calendar-events.time') !!}"
            id="start-time"
            value="{{ isset($calendarEvent) ? date('H:i:s', strtotime($calendarEvent->start)) : null }}"
    />
    <br />

    {{-- End date --}}
    <label for="end">{!! trans('calendar-events::calendar-events.end') !!}</label>
    <input
            type="text"
            name="end[date]"
            placeholder="{!! trans('calendar-events::calendar-events.end') !!}"
            id="end"
            value="{{ (isset($calendarEvent) && false === $calendarEvent->all_day) ? strtotime('Y-m-d', $calendarEvent->end) : null }}"
    />
    -
    <input
            type="text"
            name="end[time]"
            placeholder="{!! trans('calendar-events::calendar-events.time') !!}"
            id="end-time"
            value="{{ (isset($calendarEvent) && false === $calendarEvent->all_day) ? strtotime('H:i:s', $calendarEvent->end) : null }}"
    />
    <br />

    <?php $colors = \Todstoychev\Wsc\Wsc::getColors(); ?>

    {{-- Border color --}}
    <label for="border-color">{!! trans('calendar-events::calendar-events.border_color') !!}</label>
    <select name="border_color" id="border-color">
        <option value="">{!! trans('calendar-events::calendar-events.select_color') !!}</option>
        @foreach($colors as $color)
        <option
                value="#{{ $color }}"
                style="background-color: #{{ $color }}"
                {{ (isset($calendarEvent) && '#' . $color == $calendarEvent->border_color) ? 'selected=\"\"' : null }}
        >
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
        <option
                value="#{{ $color }}"
                style="background-color: #{{ $color }}"
                {{ (isset($calendarEvent) && '#' . $color == $calendarEvent->background_color) ? 'selected=\"\"' : null }}
        >
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
        <option
                value="#{{ $color }}"
                style="background-color: #{{ $color }}"
                {{ (isset($calendarEvent) && '#' . $color == $calendarEvent->text_color) ? 'selected=\"\"' : null }}
        >
            #{{ $color }}
        </option>
        @endforeach
    </select>
    <br />

    {{-- Reapeat event checkbox --}}
    <label for="repeat">
        <input
                type="checkbox"
                name="repeat"
                id="repeat"
                onchange="CalendarEvents.repeatEventToggle();"
                {{ (isset($calendarEvent) && $calendarEvent->calendarEventRepeatDates()->count() > 0) ? 'checked=\"\"' : null }}
        />
        {!! trans('calendar-events::calendar-events.repeat_event') !!}
    </label>
    <br />

    {{-- Repeat events block --}}
    <div id="repeat-event">
        @include('calendar-events::repeat-dates')
    </div>

    <input type="submit" value="{!! trans('calendar-events::calendar-events.save') !!}" />
</form>
