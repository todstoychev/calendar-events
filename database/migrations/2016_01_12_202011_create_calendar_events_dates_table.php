<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEventsDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('all_day')->default(false);
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->integer('calendar_event_id');
            $table->timestamps();

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
        Schema::drop('calendar_events_dates');
    }
}
