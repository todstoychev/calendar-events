<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEventsRepeatDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repeat_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->date('repeat_date');
            $table->integer('calendar_event_id');
            $table->foreign('calendar_event_id')
                ->references('id')
                ->on('calendar_events')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('calendar_events_repeat_dates');
    }
}
