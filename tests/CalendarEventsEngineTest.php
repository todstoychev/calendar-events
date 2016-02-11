<?php

namespace Todstoychev\CalendarEvents\Tests;

use Carbon\Carbon;
use Todstoychev\CalendarEvents\Engine\CalendarEventsEngine;
use Todstoychev\CalendarEvents\Models\CalendarEvent;

/**
 * @package Todstoychev\CalendarEvents\Tests
 * @author Todor Todorov <todstoychev@gmail.com>
 */
class CalendarEventsEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CalendarEventsEngine
     */
    protected $calendarEventsEngine;

    protected function setUp()
    {
        $this->calendarEventsEngine = new CalendarEventsEngine(new Carbon());
    }

    /**
     * Test constructor
     */
    public function testConstruct()
    {
        static::assertAttributeInstanceOf('Carbon\Carbon', 'carbon', $this->calendarEventsEngine);
    }

    /**
     * Test buildEventData with correct data
     */
    public function testBuildEventDataWithCorrectData()
    {
        $data = [
            'title' => 'Title',
            'description' => 'Description',
            'start' => [
                'date' => '2015-10-01',
                'time' => '10:00:00'
            ],
            'end' => [
                'date' => '2015-10-01',
                'time' => '11:00:00'
            ],
            'text_color' => '#000000',
            'border_color' => '#666666',
            'background_color' => '#ffffff'
        ];

        $event = $this->calendarEventsEngine->buildEventData($data);

        $expected = $data;
        $expected['start'] = date('Y-m-d H:i:s', strtotime($data['start']['date'] . ' ' . $data['start']['time']));
        $expected['end'] = date('Y-m-d H:i:s', strtotime($data['end']['date'] . ' ' . $data['end']['time']));
        $expected['all_day'] = false;

        static::assertEquals($expected, $event);

        unset($data['end']);
        $expected['end'] = null;
        $data['all_day'] = 'On';
        $expected['all_day'] = true;

        $event = $this->calendarEventsEngine->buildEventData($data);

        static::assertEquals($expected, $event);
    }

    /**
     * Tests buildEventData with wrong data
     */
    public function testBuildEventDataException()
    {
        $data = [
            'title' => 'Title',
            'description' => 'Description',
            'start' => [
                'date' => '2015-10-02',
                'time' => '10:00:00'
            ],
            'end' => [
                'date' => '2015-10-01',
                'time' => '11:00:00'
            ],
            'text_color' => '#000000',
            'border_color' => '#666666',
            'background_color' => '#ffffff'
        ];

        static::setExpectedException(
            'Todstoychev\CalendarEvents\Exceptions\DateDifferenceException',
            'Start date bigger then end date!'
        );

        $this->calendarEventsEngine->buildEventData($data);
    }

    /**
     * Test build repeat dates with all day event
     */
    public function testBuildEventDatesWithAllDay()
    {
        $data = [
            'start' => [
                'date' => '2016-09-30',
                'time' => '10:00:00',
            ],
            'all_day' => 'On',
            'repeat_dates' => [
                '2016-10-01',
                '2016-10-02',
                '2016-10-03'
            ]
        ];

        $expected = [
            [
                'start' => '2016-10-01 10:00:00',
                'end' => null
            ],
            [
                'start' => '2016-10-02 10:00:00',
                'end' => null
            ],
            [
                'start' => '2016-10-03 10:00:00',
                'end' => null
            ],
        ];

        $result = $this->calendarEventsEngine->buildEventDates($data);

        static::assertSame($expected, $result);
    }

    /**
     * Test build repeat events dates without all day
     */
    public function testBuildEventDatesWithoutAllDay()
    {
        $data = [
            'start' => [
                'date' => '2016-09-30',
                'time' => '10:00:00',
            ],
            'end' => [
                'date' => '2016-09-30',
                'time' => '11:00:00'
            ],
            'repeat_dates' => [
                '2016-10-01',
                '2016-10-02',
                '2016-10-03'
            ]
        ];

        $expected = [
            [
                'start' => '2016-10-01 10:00:00',
                'end' => '2016-10-01 11:00:00'
            ],
            [
                'start' => '2016-10-02 10:00:00',
                'end' => '2016-10-02 11:00:00'
            ],
            [
                'start' => '2016-10-03 10:00:00',
                'end' => '2016-10-03 11:00:00'
            ],
        ];

        $result = $this->calendarEventsEngine->buildEventDates($data);

        static::assertSame($expected, $result);
    }
}
