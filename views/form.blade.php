<form action="" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    {{-- Title field --}}
    <label for="title">*{!! trans('calendar.title') !!}</label>
    <input name="title" type="text" placeholder="{!! trans('calendar.title') !!}" />
    <br />

    {{-- Description --}}
    <label for="description">{!! trans('calendar.description') !!}</label>
    <textarea name="description" placeholder="{!! trans('calendar.your_text_here') !!}"></textarea>
    <br />

    {{-- All day check box --}}
    <label for="all_day">
        <input type="checkbox" name="all_day" value="true" />
        {!! trans('calendar.all_day') !!}
    </label>
    <br />

    {{-- Start date --}}
    <label for="start">{!! trans('calendar.start') !!}</label>
    <input type="text" name="start" placeholder="{!! trans('calendar.start') !!}" />
    <br />

    {{-- End date --}}
    <label for="end">{!! trans('calendar.end') !!}</label>
    <input type="text" name="end" placeholder="{!! trans('calendar.end') !!}" />
    <br />

    <?php $colors = \Todstoychev\Wsc\Wsc::getColors(); ?>

    {{-- Border color --}}
    <label for="border_color">{!! trans('calendar.border_color') !!}</label>
    <select name="border_color">
        <option value="">{!! trans('calendar.select_color') !!}</option>
        @foreach($colors as $color)
        <option value="#{{ $color }}" style="background-color: #{{ $color }}">
            #{{ $color }}
        </option>
        @endforeach
    </select>
    <br />

    {{-- Background color --}}
    <label for="background_color">{!! trans('calendar.background_color') !!}</label>
    <select name="border_color">
        <option value="">{!! trans('calendar.background_color') !!}</option>
        @foreach($colors as $color)
        <option value="#{{ $color }}" style="background-color: #{{ $color }}">
            #{{ $color }}
        </option>
        @endforeach
    </select>
    <br />

    {{-- Text color --}}
    <label for="text_color">{!! trans('calendar.text_color') !!}</label>
    <select name="text_color">
        <option value="">{!! trans('calendar.text_color') !!}</option>
        @foreach($colors as $color)
        <option value="#{{ $color }}" style="background-color: #{{ $color }}">
            #{{ $color }}
        </option>
        @endforeach
    </select>
    <br />

    {{-- Reapeat event checkbox --}}
    <label for="repeat">
        <input type="checkbox" name="repeat" />
        {!! trans('calendar.repeat_event') !!}
    </label>
    <br />

    {{-- Repeat events block --}}
    <div class="repeat-event">
        @include('calendar::repeat-form')

        {{-- Exclude dates checkbox --}}
        <label for="exclude_dates">
            <input type="checkbox" name="exclude_dates" />
            {!! trans('calendar.exclude_dates') !!}
        </label>
        <br />

        {{-- Include dates checkbox --}}
        <label for="include_dates">
            <input type="checkbox" name="include_dates" />
            {!! trans('calendar.include_dates') !!}
        </label>

        {{-- Exclude date --}}
        <div class="exclude-dates">
            @include('calendar::exclude-dates')
        </div>

        {{-- Include dates --}}
        <div class="include-dates">
            @include('calendar::include-dates')
        </div>
    </div>
</form>
