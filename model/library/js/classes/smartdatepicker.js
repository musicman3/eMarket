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
        var new_date = new Date();
        var startDate,
                endDate,
                updateStartDate = function () {
                    startPicker.setStartRange(startDate);
                    endPicker.setStartRange(startDate);
                    //endPicker.setMinDate(startDate);
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
                    }
                }),
                endPicker = new Pikaday({
                    field: document.querySelector('#end_date'),
                    position: 'top left',
                    toString(date, format) {
                        moment.locale(document.documentElement.lang);
                        return moment(date).format('L');
                    },
                    minDate: new Date(new_date.setDate(new_date.getDate() + 1)),
                    onSelect: function () {
                        endDate = this.getDate();
                        updateEndDate();
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