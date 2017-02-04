{{-- Longitude --}}
<label for="longitude">@lang('calendar-events.longitude')</label>
<input type="text" 
       name="longitude"
       id="longitude"
       placeholder="@lang('calendar-events.longitude')"
       value="{{ (isset($calendarEvent) && !empty($calendarEvent->eventLocation->longitude)) ? $calendarEvent->eventLocation->longitude : null}}"
/>

{{-- Latitude --}}
<label for="latitude">@lang('calendar-events.latitude')</label>
<input type="text"
       name="latitude"
       id="latitude"
       placeholder="@lang('calendar-events.latitude')"
       value="{{ (isset($calendarEvent) && !empty($calendarEvent->eventLocation->latitude)) ? $calendarEvent->eventLocation->latitude : null}}"
/>

{{-- Address --}}
<label for="address">@lang('calendar-events.address')</label>
<input type="text"
       name="address"
       id="address"
       placeholder="@lang('calendar-events.address')"
       value="{{ (isset($calendarEvent) && !empty($calendarEvent->eventLocation->address)) ? $calendarEvent->eventLocation->address : null}}"
/>

