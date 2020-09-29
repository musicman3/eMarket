/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Значения атрибута
 *
 * @package Values Attributes
 * @author eMarket
 * 
 */
class ValuesAttribute {
    /**
     * Конструктор
     *
     * @param lang {Json} (Языковые переменные)
     */
    constructor(lang) {
        this.modal(lang);
        this.click(lang);
    }

    /**
     * Инициализация для модалов
     *
     *@param lang {Array} (Языковые переменные)
     */
    modal(lang) {

        // Если открыли модал списка в группе атрибутов
        $('#values_attribute').on('show.bs.modal', function (event) {

            var data_id = sessionStorage.getItem('level_2');

            if (sessionStorage.getItem('attributes') !== null) {
                var jsdata = new JsData();
                var parse_attributes = jsdata.selectParentUids(data_id, $.parseJSON(sessionStorage.getItem('attributes')));

                ValuesAttribute.add(lang, parse_attributes);
            }
            // Загружаем удаление атрибута
            ValuesAttribute.deleteValue(lang);

        });

        // Если закрыли модал списка значений атрибута
        $('#values_attribute').on('hidden.bs.modal', function (event) {
            $('.values_attribute').empty();
        });

        // Если закрыли модал добавления значения атрибута
        $('#add_values_attribute').on('hidden.bs.modal', function (event) {
            $('.input-add-values-attribute').val('');
            // Загружаем удаление значения атрибута
            ValuesAttribute.deleteValue(lang);
        });
    }

    /**
     * Инициализация для кликов
     *
     *@param lang {Array} (Языковые переменные)
     */
    click(lang) {

        // Добавляем значение атрибута
        $(document).on('click', '.add-values-attribute', function () {
            $('#add_values_attribute').modal('show');
            sessionStorage.setItem('action', 'add');
        });

        // Редактируем значения атрибута
        $(document).on('click', '.edit-value-attribute', function () {
            $('#add_values_attribute').modal('show');
            var processing = new AttributesProcessing();
            processing.clickEdit($(this).closest('tr').attr('id').split('_')[1], sessionStorage.getItem('level_2'), 'level_3');

        });

        // Сохраняем значение атрибута
        $(document).on('click', '#save_add_values_attribute', function () {
            $('#add_values_attribute').modal('hide');

            var attributes_bank = $('#add_values_attribute_form').serializeArray();
            var data_id = sessionStorage.getItem('level_2');
            var jsdata = new JsData();
            var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

            if (sessionStorage.getItem('action') === 'add') {
                var parse_attributes_add = jsdata.add(attributes_bank, parse_attributes, data_id);

                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_add));
                var parse_attributes_view = jsdata.selectParentUids(data_id, $.parseJSON(sessionStorage.getItem('attributes')));
                ValuesAttribute.add(lang, parse_attributes_view);
            }

            if (sessionStorage.getItem('action') === 'edit') {
                var id = sessionStorage.getItem('level_3');
                var parse_attributes_edit = jsdata.editUid(id, parse_attributes, attributes_bank);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_edit));
                var parse_attributes_view = jsdata.selectParentUids(data_id, $.parseJSON(sessionStorage.getItem('attributes')));
                ValuesAttribute.add(lang, parse_attributes_view);
            }

            $('.input-add-values-attribute').val('');
        });

    }

    /**
     * Отображение значений атрибутов
     *
     * @param id {String} (id строки)
     * @param value {String} (значение строки)
     * @param lang {Array} (Языковые переменные)
     */
    static addValue(id, value, lang) {
        $('.values_attribute').prepend(
                '<tr class="value-attributes-class" id="valueattributes_' + id + '">' +
                '<td class="sortyes-value-attributes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button type="button" class="delete-value-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="' + lang[0] + '" data-btn-cancel-label="' + lang[1] + '" title="' + lang[2] + '"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button type="button" class="edit-value-attribute btn btn-primary btn-xs" title="' + lang[3] + '"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    /**
     * Удаление значений атрибутов
     * 
     * @param lang {Array} (Языковые переменные)
     *
     */
    static deleteValue(lang) {
        $('.delete-value-attribute').confirmation({
            onConfirm: function (event) {
                $(this).closest('tr').remove();

                var jsdata = new JsData();
                var data_id = sessionStorage.getItem('level_2');
                var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

                var parse_attributes_delete = jsdata.deleteUid($(this).closest('tr').attr('id').split('_')[1], parse_attributes);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_delete));

                var parse_attributes_add = jsdata.selectParentUids(data_id, $.parseJSON(sessionStorage.getItem('attributes')));
                ValuesAttribute.add(lang, parse_attributes_add);
                // Загружаем удаление атрибута
                ValuesAttribute.deleteValue(lang);
            }});
    }

    /**
     * Сортировка значений атрибутов
     * 
     * @param lang {Array} (Языковые переменные)
     *
     */
    static sort(lang) {
        var sortedIDs = $(".values_attribute").sortable("toArray").reverse();

        var data_id = sessionStorage.getItem('level_2');
        var jsdata = new JsData();
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        var parse_attributes_sort = jsdata.selectParentUids(data_id, $.parseJSON(sessionStorage.getItem('attributes')));
        var sort = jsdata.sortToListUid(sortedIDs, parse_attributes_sort);

        var sorted = jsdata.replaceUids(sort, parse_attributes);

        sessionStorage.setItem('attributes', JSON.stringify(sorted));
        var parse_attributes_add = jsdata.selectParentUids(data_id, $.parseJSON(sessionStorage.getItem('attributes')));

        ValuesAttribute.add(lang, parse_attributes_add);
        ValuesAttribute.deleteValue(lang);
    }

    /**
     * Добавление атрибутов
     * 
     * @param lang {Array} (Языковые переменные)
     * @param parse {Array} (Данные по атрибутам)
     *
     */
    static add(lang, parse) {

        var jsdata = new JsData();
        var parse_attributes_sort = jsdata.sort(parse);

        $('.values_attribute').empty();
        parse.forEach((string, index) => {
            var sort_id = string.length - 1;
            ValuesAttribute.addValue(parse_attributes_sort[index][sort_id].uid, parse_attributes_sort[index][0].value, lang);
        });
    }
}