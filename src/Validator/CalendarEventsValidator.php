<?php

namespace Todstoychev\CalendarEvents\Validator;

use Illuminate\Validation\Validator;

/**
 * Calendar events custom validation rules
 *
 * @package Todstoychev\CalendarEvents\Validator
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventsValidator
{
    /**
     * Validate time
     *
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @param Validator $validator
     *
     * @return bool
     */
    public function validateTime($attribute, $value, array $parameters, Validator $validator)
    {
        return (bool)preg_match('/([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?/', $value);
    }

    /**
     * Validate array of dates
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param Validator $validator
     *
     * @return bool
     */
    public function validateDatesArray($attribute, $value, array $parameters, Validator $validator)
    {
        foreach ($value as $date) {
            if (false === strtotime($date) || empty($date)) {
                return false;
            }
        }

        return true;
    }
}