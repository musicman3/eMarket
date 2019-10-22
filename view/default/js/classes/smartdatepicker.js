/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Класс для расширения функций bootstrap-datepicker
 *
 * @package Smart
 * @author eMarket
 * 
 */
class SmartDatepicker {
    /**
     * Конструктор
     *
     * @param meta string (meta для языка)
     */
    constructor(meta) {
        this.meta = meta;
        this.datepicker();
    }
    /**
     * Двухдиапазонный календарь с автоматическим ограничением
     *
     */
    datepicker() {
        //Инициализация
        $('#start_date, #start_date_edit').datepicker({
            language: this.meta,
            autoclose: true,
            updateViewDate: false,
            clearBtn: true,
            startDate: '+0d',
            calendarWeeks: true
        });
        $('#end_date, #end_date_edit').datepicker({
            language: this.meta,
            autoclose: true,
            updateViewDate: false,
            clearBtn: true,
            startDate: '+1d',
            calendarWeeks: true
        });

        this.view('#start_date_edit', '#end_date_edit');
        this.view('#start_date', '#end_date');

        //Очищаем при закрытии модала
        $('#edit').on('hidden.bs.modal', function (event) {
            $('#start_date_edit, #end_date_edit').datepicker('clearDates');
        });
    }

    /**
     * Вывод в detepicker
     *
     * @param start string (id start-поля datepicker)
     * @param end string (id end-поля datepicker)
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