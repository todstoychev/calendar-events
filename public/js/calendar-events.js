var CalendarEvents = {
    /**
     * The init method. Sets the states of the blocks.
     */
    init: function () {
        this.allDayToggle();
        this.repeatEventToggle();
        this.eventLocationToggle();
        this.removeField();
    },

    /**
     * Toggles all day on and off
     */
    allDayToggle: function () {
        if ($('#all-day').prop('checked')) {
            $('#end').prop('disabled', true);
            $('#end-time').prop('disabled', true);
        } else {
            $('#end').removeAttr('disabled');
            $('#end-time').removeAttr('disabled');
        }
    },

    /**
     * Toggle repeat event
     */
    repeatEventToggle: function () {
        if ($('#repeat').prop('checked')) {
            $('div#repeat-event').show();
        } else {
            $('div#repeat-event').hide();
        }
    },

    /**
     * Add include date field
     */
    addRepeatDateField: function () {
        var field = $('button#add-repeat-date-field').siblings('div.repeat-date-field').first().html();
        $('button#add-repeat-date-field').before('<div class="repeat-date-field">' + field + '</div>');
    },

    /**
     * Toggles event location form
     */
    eventLocationToggle: function () {
        if ($('#use-event-location').prop('checked')) {
            $('div#event-location').show();
        } else {
            $('div#event-location').hide();
        }
    },

    /**
     * Acts on remove field
     */
    removeField: function () {
        $(document).on('click', 'button.remove-field', function () {
            if ($('button.remove-field').length > 1) {
                $(this).parent().remove();
            }
        });
    }
}
