var CalendarEvents = {
    /**
     * The init method. Sets the states of the blocks.
     */
    init: function () {
        this.allDayToggle();
        this.repeatEventToggle();
        this.repeatOnWeekdaysToggle();
        this.excludeDatesToggle();
        this.includeDatesToggle();
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
     * Repeat on certain weekdays toggle
     */
    repeatOnWeekdaysToggle: function () {
        if ($('#weekdays').prop('checked')) {
            $('#repeat-at').show();
        } else {
            $('#repeat-at').hide();
        }
    },

    /**
     * Exclude dates blovk toggle
     */
    excludeDatesToggle: function () {
        if ($('#exclude-dates').prop('checked')) {
            $('#exclude-dates-block').show();
        } else {
            $('#exclude-dates-block').hide();
        }
    },

    /**
     * Include dates toggle
     */
    includeDatesToggle: function () {
        if ($('#include-dates').prop('checked')) {
            $('#include-dates-block').show();
        } else {
            $('#include-dates-block').hide();
        }
    }
}

// Listen for events
$('input#all-day').on('change', function () {
    CalendarEvents.allDayToggle();
});

$('input#repeat').on('change', function () {
    CalendarEvents.repeatEventToggle();
});

$('input#weekdays').on('change', function () {
    CalendarEvents.repeatOnWeekdaysToggle();
});

$('input#exclude-dates').on('change', function () {
    CalendarEvents.excludeDatesToggle();
});

$('input#include-dates').on('change', function () {
    CalendarEvents.includeDatesToggle();
});