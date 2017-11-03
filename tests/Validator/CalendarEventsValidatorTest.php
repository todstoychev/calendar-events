<?php

namespace Todstoychev\CalendarEvents\Tests\Validator;

use Illuminate\Validation\Validator;
use Todstoychev\CalendarEvents\Validator\CalendarEventsValidator;
use PHPUnit\Framework\TestCase;

class CalendarEventsValidatorTest extends TestCase
{
    /**
     * @var CalendarEventsValidator
     */
    private $valdator;

    /**
     * @var Validator
     */
    private $validatorMock;

    protected function setUp()
    {
        $this->valdator = new CalendarEventsValidator();
        $this->validatorMock = static::createMock(Validator::class);
    }

    public function testValidateTimeWithCorrectTimeStrign()
    {
        $result = $this->valdator->validateTime('time', '10:00:00', [], $this->validatorMock);

        static::assertTrue($result);
    }

    public function testValidateTimeWithWrongTimeString()
    {
        $result = $this->valdator->validateTime('time', '45:87:78', [], $this->validatorMock);

        static::assertFalse($result);
    }

    public function testValidateDatesArrayWithCorrectValues()
    {
        $dates = [
            '10.10.2016',
            '10-12-2017',
            '2017-10-02',
            '01/02/2002',
        ];
        $result = $this->valdator->validateDatesArray('dates', $dates, [], $this->validatorMock);

        static::assertTrue($result);
    }

    public function testValidateDatesArrayWithWrongDate()
    {
        $dates = [
            '10.10.2016',
            '10-13-2017',
            '2017-10-02',
            '45/02/2002',
        ];
        $result = $this->valdator->validateDatesArray('dates', $dates, [], $this->validatorMock);

        static::assertFalse($result);
    }
}
