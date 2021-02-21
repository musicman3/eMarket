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
                        months: [moment.months()[0], moment.months()[1], moment.months()[2], moment.months()[3], moment.months()[4], moment.months()[5], moment.months()[6], moment.months()[7], moment.months()[8], moment.months()[9], moment.months()[10], moment.months()[11]],
                        weekdays: [moment.weekdays()[0], moment.weekdays()[1], moment.weekdays()[2], moment.weekdays()[3], moment.weekdays()[4], moment.weekdays()[5], moment.weekdays()[6]],
                        weekdaysShort: [moment.weekdaysMin()[0], moment.weekdaysMin()[1], moment.weekdaysMin()[2], moment.weekdaysMin()[3], moment.weekdaysMin()[4], moment.weekdaysMin()[5], moment.weekdaysMin()[6]]
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
                        months: [moment.months()[0], moment.months()[1], moment.months()[2], moment.months()[3], moment.months()[4], moment.months()[5], moment.months()[6], moment.months()[7], moment.months()[8], moment.months()[9], moment.months()[10], moment.months()[11]],
                        weekdays: [moment.weekdays()[0], moment.weekdays()[1], moment.weekdays()[2], moment.weekdays()[3], moment.weekdays()[4], moment.weekdays()[5], moment.weekdays()[6]],
                        weekdaysShort: [moment.weekdaysMin()[0], moment.weekdaysMin()[1], moment.weekdaysMin()[2], moment.weekdaysMin()[3], moment.weekdaysMin()[4], moment.weekdaysMin()[5], moment.weekdaysMin()[6]]
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