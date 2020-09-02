/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Атрибуты
 *
 * @package Attributes
 * @author eMarket
 * 
 */
class Attributes {
    /**
     * Конструктор
     *
     * @param lang json (Языковые переменные)
     */
    constructor(lang) {
        this.modal(lang);
        this.click(lang);
    }

    /**
     * Инициализация для модалов
     *
     *@param lang array (Языковые переменные)
     */
    modal(lang) {

        // Если открыли модал списка в группе атрибутов
        $('#attribute').on('show.bs.modal', function (event) {

            if (sessionStorage.getItem('value_attribute_flag') === null) {
                Attributes.clearAttributes();
            }
            var group_id = sessionStorage.getItem('group_attribute_id');

            if (sessionStorage.getItem('attributes') !== null) {
                var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

                if (parse_attributes[group_id] !== undefined) {
                    Attributes.add(lang, parse_attributes[group_id]);
                }
            }
            // Загружаем удаление атрибута
            Attributes.deleteAttribute(lang);

        });

        // Если закрыли модал списка в группе атрибутов
        $('#attribute').on('hidden.bs.modal', function (event) {
            $('.attribute').empty();
            if (sessionStorage.getItem('value_attribute_flag') === '0') {
                Attributes.clearAttributes();
            }
        });

        // Если закрыли модал значения атрибута
        $('#add_attribute').on('hidden.bs.modal', function (event) {
            $('.input-add-attribute').val('');
            // Загружаем удаление атрибута
            Attributes.deleteAttribute(lang);
        });
    }

    /**
     * Инициализация для кликов
     *
     *@param lang array (Языковые переменные)
     */
    click(lang) {
        // Добавляем атрибут
        $(document).on('click', '.add-attribute', function () {
            sessionStorage.setItem('attribute_action', 'add');
            $('#add_attribute').modal('show');
        });

        // Редактируем атрибут
        $(document).on('click', '.edit-attribute', function () {
            var id = $(this).closest('tr').attr('id').split('_')[1];
            var group_id = sessionStorage.getItem('group_attribute_id');

            sessionStorage.setItem('attribute_action', 'edit');
            sessionStorage.setItem('edit_attribute_id', id);

            $('#add_attribute').modal('show');

            var parse_attributes = [];
            if (sessionStorage.getItem('attributes') !== null) {
                parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'))[group_id][id - 1];
            }

            for (var x = 0; x < parse_attributes.length; x++) {
                $('input[name="' + parse_attributes[x]['name'] + '"]').val(parse_attributes[x]['value']);
            }

        });

        // Сохраняем атрибут
        $('#save_attribute_button').click(function () {
            $('#add_attribute').modal('hide');

            var attributes_bank = $('#attribute_add_form').serializeArray();
            var group_id = sessionStorage.getItem('group_attribute_id');
            var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

            //Если атрибут добавляется
            if (sessionStorage.getItem('attribute_action') === 'add') {
                if (parse_attributes === null || parse_attributes.length === 0) {
                    parse_attributes = [];
                }
                if (parse_attributes[group_id] === undefined) {
                    parse_attributes[group_id] = [];
                }

                parse_attributes[group_id].push(attributes_bank);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                Attributes.add(lang, parse_attributes[group_id]);
                sessionStorage.setItem('value_attribute_flag', '0');
            }

            //Если атрибут редактируется
            if (sessionStorage.getItem('attribute_action') === 'edit') {

                var id = sessionStorage.getItem('edit_attribute_id');

                for (x = 0; x < attributes_bank.length; x++) {
                    for (let y = 0; y < parse_attributes[group_id][id - 1].length; y++) {
                        if (parse_attributes[group_id][id - 1][x]['name'] === attributes_bank[y]['name']) {
                            parse_attributes[group_id][id - 1][x]['value'] = attributes_bank[y]['value'];
                        }
                    }
                }

                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                Attributes.add(lang, parse_attributes[group_id]);
            }

            $('.input-add-attribute').val('');
        });
    }

    /**
     * Отображение атрибутов
     *
     * @param id string (id строки)
     * @param value string (значение строки)
     * @param lang array (Языковые переменные)
     */
    static addAttribute(id, value, lang) {
        $('.attribute').prepend(
                '<tr class="attributes-class" id="attributes_' + id + '">' +
                '<td class="sortyes-attributes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>' +
                '<td class="sortleft-m"><button type="button" class="values-attribute btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></button></td>' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button type="button" class="delete-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="' + lang[0] + '" data-btn-cancel-label="' + lang[1] + '>" title="' + lang[2] + '"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button type="button" class="edit-attribute btn btn-primary btn-xs" title="' + lang[3] + '"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    /**
     * Удаление атрибутов
     * 
     * @param lang array (Языковые переменные)
     *
     */
    static deleteAttribute(lang) {
        $('.delete-attribute').confirmation({
            onConfirm: function (event) {
                $(this).closest('tr').remove();

                var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
                var group_id = sessionStorage.getItem('group_attribute_id');

                parse_attributes[group_id].splice($(this).closest('tr').attr('id').split('_')[1] - 1, 1);

                if (parse_attributes[group_id].length === 0) {
                    parse_attributes = [];
                }
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                Attributes.add(lang, parse_attributes[group_id]);
                // Загружаем удаление атрибута
                Attributes.deleteAttribute(lang);
            }});
    }

    /**
     * Сортировка массива атрибутов
     * 
     * @param array array (Входящий массив)
     * @param sort_list string (Массив сортировки)
     *
     */
    static sort(array, sort_list) {
        var new_array = [];
        sort_list.reverse();

        for (var x = 0; x < array.length; x++) {
            new_array[x] = array[sort_list[x].split('_')[1] - 1];
        }

        return new_array;
    }

    /**
     * Сортировка атрибутов
     * 
     * @param lang array (Языковые переменные)
     *
     */
    static sortAttributes(lang) {
        var sortedIDs = $(".attribute").sortable("toArray");

        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        var group_id = sessionStorage.getItem('group_attribute_id');
        var sort = Attributes.sort(parse_attributes[group_id], sortedIDs);
        parse_attributes[group_id] = sort;
        sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

        var parse_attributes_new = $.parseJSON(sessionStorage.getItem('attributes'));
        Attributes.add(lang, parse_attributes_new[group_id]);
        Attributes.deleteAttribute(lang);
    }

    /**
     * Добавление атрибутов
     * 
     * @param lang array (Языковые переменные)
     * @param parse array (Данные по атрибутам)
     *
     */
    static add(lang, parse) {

        $('.attribute').empty();
        for (var x = 0; x < parse.length; x++) {
            var y = x + 1;
            Attributes.addAttribute(y, parse[x][0]['value'], lang);
        }
    }

    /**
     * Очистка атрибутов
     *
     */
    static clearAttributes() {
        ['attribute_action',
            'edit_attribute_id',
            'edit_value_attribute_id',
            'value_attribute_action',
            'value_attribute_action_id',
            'value_attribute_flag'
        ].forEach((item) => sessionStorage.removeItem(item));
    }
}