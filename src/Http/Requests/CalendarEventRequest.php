<?php

namespace Todstoychev\CalendarEvents\Http\Requests;

use App\Http\Requests\Request;

/**
 * Calendar events form request
 *
 * @package Todstoychev\CalendarEvents\Http\Requests
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventRequest extends Request
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

        if (!empty($this->input('repeat_event'))) {
            $rules['repeat_type'] = 'required|alpha_num';
            $rules['stop_repeat_at'] = 'date';
            $rules['repeat_times'] = 'numeric';

            if ($this->input('repeat_end') == 'date') {
                $rules['stop_repeat'] = 'required|date';
            }

            if ($this->input('repeat_end') == 'times') {
                $rules['stop_repeat'] = 'required|numeric';
            }
        }

        if (!empty($this->input('toggle_exclude_dates'))) {
            $rules['exclude_dates'] = 'dates_array';
        }

        if (!empty($this->input('toggle_include_dates'))) {
            $rules['include_dates'] = 'dates_array';
        }

        if (!empty($this->input('stop_repeat_at'))) {
            $rules['repeat_times'] = 'required|numeric';
        }

        if (!empty($this->input('repeat_times'))) {
            $rules['stop_repeat_at'] = 'required|date';
        }

        return $rules;
    }
}
