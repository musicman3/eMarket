/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global moment */

/**
 * Dual range picker with auto limit for bootstrap-datepicker
 *
 * @package SmartDatepicker
 * @author eMarket
 * 
 */
class SmartDatepicker {
    /**
     * Constructor
     *
     * @param start string (start date)
     * @param end string (end date)
     */
    constructor(start = '', end = '') {
        this.init(start, end);
    }
    /**
     * Init
     *
     * @param start string (start date)
     * @param end string (end date)
     */
    init(start, end) {
        var months = moment.months();
        var weekdays = moment.weekdays();
        var weekdays_min = moment.weekdaysMin();
        
        var startDate,
                endDate,
                updateStartDate = function () {
                    startPicker.setStartRange(startDate);
                    endPicker.setStartRange(startDate);
                    endPicker.setMinDate(startDate);
                },
                updateEndDate = function () {
                    startPicker.setEndRange(endDate);
                    startPicker.setMaxDate(endDate);
                    endPicker.setEndRange(endDate);
                },
                startPicker = new Pikaday({
                    field: document.querySelector('#start_date'),
                    position: 'top left',
                    toString(date, format) {
                        moment.locale(document.documentElement.lang);
                        return moment(date).format('L');
                    },
                    minDate: new Date(),
                    onSelect: function () {
                        startDate = this.getDate();
                        updateStartDate();
                    },
                    i18n: {
                        months: [months[0], months[1], months[2], months[3], months[4], months[5], months[6], months[7], months[8], months[9], months[10], months[11]],
                        weekdays: [weekdays[0], weekdays[1], weekdays[2], weekdays[3], weekdays[4], weekdays[5], weekdays[6]],
                        weekdaysShort: [weekdays_min[0], weekdays_min[1], weekdays_min[2], weekdays_min[3], weekdays_min[4], weekdays_min[5], weekdays_min[6]]
                    }
                }),
                endPicker = new Pikaday({
                    field: document.querySelector('#end_date'),
                    position: 'top left',
                    toString(date, format) {
                        moment.locale(document.documentElement.lang);
                        return moment(date).format('L');
                    },
                    minDate: new Date(),
                    onSelect: function () {
                        endDate = this.getDate();
                        updateEndDate();
                    },
                    i18n: {
                        months: [months[0], months[1], months[2], months[3], months[4], months[5], months[6], months[7], months[8], months[9], months[10], months[11]],
                        weekdays: [weekdays[0], weekdays[1], weekdays[2], weekdays[3], weekdays[4], weekdays[5], weekdays[6]],
                        weekdaysShort: [weekdays_min[0], weekdays_min[1], weekdays_min[2], weekdays_min[3], weekdays_min[4], weekdays_min[5], weekdays_min[6]]
                    }
                }),
                _startDate = startPicker.setDate(new Date(start)),
                _endDate = endPicker.setDate(new Date(end));

        if (_startDate) {
            startDate = _startDate;
            updateStartDate();
        }

        if (_endDate) {
            endDate = _endDate;
            updateEndDate();
        }

        document.querySelector('#index').addEventListener('hidden.bs.modal', function (event) {
            startPicker.destroy();
            endPicker.destroy();
        });
    }
}