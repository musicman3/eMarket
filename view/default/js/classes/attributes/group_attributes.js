/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Группа атрибутов
 *
 * @package Group Attributes
 * @author eMarket
 * 
 */
class GroupAttributes {
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

        // Если открыли главный модал
        $('#index').on('show.bs.modal', function (event) {

            if (sessionStorage.getItem('group_attributes') !== null) {
                var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));
                GroupAttributes.add(lang, parse_group_attributes);
            } else {
                sessionStorage.setItem('group_attributes', JSON.stringify([]));
            }
            // Загружаем удаление группы атрибутов
            GroupAttributes.deleteGroupAttribute(lang);
        });

        // Если закрыли главный модал
        $('#index').on('hidden.bs.modal', function (event) {
            $('.group-attributes').empty();
            GroupAttributes.clearAttributes();
            sessionStorage.removeItem('attributes');
            sessionStorage.removeItem('group_attribute_id');
            sessionStorage.removeItem('group_attributes');
            sessionStorage.removeItem('group_attribute_action');
            sessionStorage.removeItem('edit_group_attribute_id');
        });

        // Если закрыли добавление группы атрибутов
        $('#add_group_attributes').on('hidden.bs.modal', function (event) {
            // Загружаем удаление группы атрибутов
            $('.input-add-group-attributes').val('');
            GroupAttributes.deleteGroupAttribute(lang);
        });
    }

    /**
     * Инициализация для кликов
     *
     *@param lang {Array} (Языковые переменные)
     */
    click(lang) {
        // Если открыли модал списка значений группы атрибута
        $(document).on('click', '.values-group-attribute', function () {
            var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));
            var jsdata = new JsData();
            var group_id = jsdata.selectUid($(this).closest('tr').attr('id').split('_')[1], parse_group_attributes, 'true');
            sessionStorage.setItem('group_attribute_id', group_id);

            $('#attribute').modal('show');
            $('#title_attribute').html('Группа атрибутов: ' + parse_group_attributes[group_id][0]['value']);

        });

        // Добавляем группу атрибутов
        $(document).on('click', '.add-group-attributes', function () {
            $('#add_group_attributes').modal('show');
            sessionStorage.setItem('group_attribute_action', 'add');
        });

        // Редактируем группу атрибутов
        $(document).on('click', '.edit-group-attribute', function () {
            var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));
            var jsdata = new JsData();
            var group_id = $(this).closest('tr').attr('id').split('_')[1];
            var group_string = jsdata.selectUid(group_id, parse_group_attributes);
            sessionStorage.setItem('edit_group_attribute_id', group_id);
            sessionStorage.setItem('group_attribute_action', 'edit');

            $('#add_group_attributes').modal('show');

            for (var x = 0; x < group_string.length - 1; x++) {
                $('input[name="' + group_string[x]['name'] + '"]').val(group_string[x]['value']);
            }
        });

        // Сохраняем значение группы атрибутов
        $(document).on('click', '#save_group_attributes_button', function () {
            $('#add_group_attributes').modal('hide');
            var group_attributes_bank = $('#group_attributes_add_form').serializeArray();
            var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
            var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));
            var jsdata = new JsData();

            //Если значение группы атрибутов добавляется
            if (sessionStorage.getItem('group_attribute_action') === 'add') {
                var parse_group_attributes_add = jsdata.add(group_attributes_bank, parse_group_attributes);

                sessionStorage.setItem('group_attributes', JSON.stringify(parse_group_attributes_add));
                GroupAttributes.add(lang, parse_group_attributes_add);
            }

            //Если значение группы атрибутов редактируется
            if (sessionStorage.getItem('group_attribute_action') === 'edit') {
                var group_id = sessionStorage.getItem('edit_group_attribute_id');
                var parse_group_attributes_edit = jsdata.editUid(group_id, parse_group_attributes, group_attributes_bank);
                sessionStorage.setItem('group_attributes', JSON.stringify(parse_group_attributes_edit));
                GroupAttributes.add(lang, parse_group_attributes_edit);
            }

        });
    }

    /**
     * Отображение группы атрибутов
     *
     * @param id {String} (id строки)
     * @param value {String} (значение строки)
     * @param lang {Array} (Языковые переменные)
     */
    static addGroupAttribute(id, value, lang) {
        $('.group-attributes').prepend(
                '<tr class="groupattributes" id="groupattributes_' + id + '">' +
                '<td class="sortyes-group sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>' +
                '<td class="sortleft-m"><button type="button" class="values-group-attribute btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></button></td>' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button type="button" class="delete-group-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="' + lang[0] + '" data-btn-cancel-label="' + lang[1] + '" title="' + lang[2] + '"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button type="button" class="edit-group-attribute btn btn-primary btn-xs" title="' + lang[3] + '"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    /**
     * Удаление группы атрибутов
     * 
     * @param lang {Array} (Языковые переменные)
     *
     */
    static deleteGroupAttribute(lang) {
        $('.delete-group-attribute').confirmation({
            onConfirm: function (event) {
                $(this).closest('tr').remove();

                var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));
                var jsdata = new JsData();

                var parse_group_attributes_delete = jsdata.deleteUid($(this).closest('tr').attr('id').split('_')[1], parse_group_attributes);

                sessionStorage.setItem('group_attributes', JSON.stringify(parse_group_attributes_delete));

                if ($.parseJSON(sessionStorage.getItem('attributes')) !== undefined) {
                    var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
                    parse_attributes.splice($(this).closest('tr').attr('id').split('_')[1] - 1, 1);
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                }

                GroupAttributes.add(lang, parse_group_attributes_delete);
                // Загружаем удаление группы атрибутов
                GroupAttributes.deleteGroupAttribute(lang);
            }
        });
    }

    /**
     * Сортировка группы атрибутов
     * 
     * @param lang {Array} (Языковые переменные)
     *
     */
    static sortGroupAttributes(lang) {
        var sortedIDs = $(".group-attributes").sortable("toArray").reverse();

        var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));

        var jsdata = new JsData();
        var sort = jsdata.sortToListUid(sortedIDs, parse_group_attributes);

        sessionStorage.setItem('group_attributes', JSON.stringify(sort));

        GroupAttributes.add(lang, sort);
        GroupAttributes.deleteGroupAttribute(lang);
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
        var parse_group_attributes_sort = jsdata.sort(parse);

        $('.group-attributes').empty();
        for (var x = 0; x < parse.length; x++) {
            GroupAttributes.addGroupAttribute(parse_group_attributes_sort[x][2]['uid'], parse_group_attributes_sort[x][0]['value'], lang);
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