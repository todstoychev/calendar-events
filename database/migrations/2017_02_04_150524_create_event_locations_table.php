<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEventLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'event_locations',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('longitude')
                      ->nullable()
                ;
                $table->string('latitude')
                      ->nullable()
                ;
                $table->string('address')
                      ->nullable()
                ;
                $table->integer('calendar_event_id')
                      ->unsigned()
                ;
                $table->timestamps();

                $table->foreign('calendar_event_id')
                      ->references('id')
                      ->on('calendar_events')
                      ->onDelete('cascade')
                      ->onUpdate('cascade')
                ;
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_locations');
    }
}
