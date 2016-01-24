var CalendarEvents = {
    /**
     * The init method. Sets the states of the blocks.
     */
    init: function () {
        this.allDayToggle();
        this.repeatEventToggle();
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
            $('#repeat-event').show();
        } else {
            $('#repeat-event').hide();
        }
    },

    /**
     * Add include date field
     */
    addRepeatDateField: function () {
        var field = $('button#add-repeat-date-field').siblings('div.repeat-date-field').first().html();
        $('button#add-repeat-date-field').before('<div class="repeat-date-field">' + field + '</div>');
    }
}

$(document).ready(function () {
    $(document).on('click', 'button.remove-field', function () {
        if ($('button.remove-field').length > 1) {
            $(this).parent().remove();
        }
    });
});