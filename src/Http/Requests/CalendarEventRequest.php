<?php

namespace Todstoychev\CalendarEvents\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Calendar events form request
 *
 * @package Todstoychev\CalendarEvents\Http\Requests
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'description' => 'min:10|max:1000',
            'start.date' => 'required|date',
            'start.time' => 'required|time',
            'border_color' => 'sometimes|regex:/#([a-fA-F\d]){6}/',
            'background_color' => 'sometimes|regex:/#([a-fA-F\d]){6}/',
            'text_color' => 'sometimes|regex:/#([a-fA-F\d]){6}/',
        ];

        if (empty($this->input('all_day'))) {
            $rules['end.date'] = 'required|date';
            $rules['end.time'] = 'required|time';
        }

        if (!empty($this->input('repeat'))) {
            $rules['repeat_dates'] = 'dates_array';
        }

        if (!empty($this->input('use_event_location'))) {
            if (empty($this->input('address')) || (empty($this->input('longitude')) || empty($this->input('latitude')))) {
                $rules['longitude'] = 'required';
                $rules['latitude'] = 'required';
            }

            if (empty($this->input('longitude')) && empty($this->input('latitude'))) {
                $rules['address'] = 'required';
             }
        }

        return $rules;
    }
}
