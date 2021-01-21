/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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
     * @param meta string (meta for languages)
     */
    constructor(meta) {
        this.meta = meta;
        this.init();
        this.view('#start_date', '#end_date');
    }
    /**
     * Init
     *
     */
    init() {
        $('#start_date').datepicker({
            language: this.meta,
            autoclose: true,
            updateViewDate: false,
            clearBtn: true,
            startDate: '+0d',
            calendarWeeks: true
        });
        $('#end_date').datepicker({
            language: this.meta,
            autoclose: true,
            updateViewDate: false,
            clearBtn: true,
            startDate: '+1d',
            calendarWeeks: true
        });

        $('#index').on('hidden.bs.modal', function (event) {
            $('#start_date, #end_date').datepicker('clearDates');
        });
    }

    /**
     * Output to datepicker
     *
     * @param start string (datepicker id start)
     * @param end string (datepicker id end)
     */
    view(start, end) {
        $(start).datepicker().on('changeDate', function (e) {
            var day_start = new Date($(start).datepicker('getDate'));
            var day_end = new Date($(end).datepicker('getDate'));
            if (day_start.setDate(day_start.getDate()) >= day_end.setDate(day_end.getDate())) {
                $(end).datepicker('setStartDate', new Date(day_start.setDate(day_start.getDate() + 1)));
                $(end).datepicker('setDate', new Date(day_start.setDate(day_start.getDate())));
            }
        });
        $(end).datepicker().on('show', function (e) {
            var day_start = new Date($(start).datepicker('getDate'));
            var day_end = new Date($(end).datepicker('getDate'));
            if (day_start.setDate(day_start.getDate()) <= day_end.setDate(day_end.getDate()) && $(start).datepicker('getDate') !== null && $(end).datepicker('getDate') !== null) {
                $(end).datepicker('setStartDate', new Date(day_start.setDate(day_start.getDate() + 1)));
            }
        });
    }
}