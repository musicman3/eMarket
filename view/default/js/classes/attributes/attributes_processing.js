/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Обработка атрибутов
 *
 * @package AttributesProcessing
 * @author eMarket
 * 
 */
class AttributesProcessing {

    /**
     * Добавление данных
     *
     * @param group_attributes array (Группа атрибутов)
     * @param attributes array (Атрибуты)
     * @param group_number string (Номер группы атрибутов)
     */
    static addData(group_attributes, attributes, group_number) {
        $('.product-attribute').prepend(
                '<h4>' + group_attributes['value'] + '</h4><table class="table table-striped product-attribute-table"><tbody id="table_' + group_number + '"></tbody></table>'
                );
        
        var selected = ["1_1_1", "1_0_0", "0_1_0", "0_0_1"];
        var selected_array = [];
        for (var x = 0; x < selected.length; x++) {
            selected_array[x] = selected[x].split('_');
        }
        var new_arr = [];
        for (var x = 0; x < selected_array.length; x++) {
            if (Number(selected_array[x][0]) === group_number) {
                new_arr.push(selected_array[x]);

            }
        }
        new_arr.reverse();

        if (attributes !== undefined && attributes !== null) {
            for (var x = 0; x < attributes.length; x++) {
                if (attributes[x][0]['data'] !== undefined && attributes[x][0]['data'] !== null) {
                    $('#table_' + group_number).prepend(
                            '<tr><td><span class="product-attribute-specification">' + attributes[x][0]['value'] + '</span></td>' +
                            '<td><div class="input-group has-success"><span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>' +
                            '<select class="form-control selectattr" id="selectattr_' + group_number + '_' + x + '"></select></div></td></tr>'
                            );

                    $('#selectattr_' + group_number + '_' + x).empty();
                    attributes[x][0]['data'].reverse();
                    $.each(attributes[x][0]['data'], function (i, p) {

                        $('#selectattr_' + group_number + '_' + x).append($('<option></option>').val(group_number + '_' + x + '_' + i).html(p));
                        if (i === Number(new_arr[x][2])) {
                            $('#selectattr_' + group_number + '_' + x + ' option[value=' + group_number + '_' + x + '_' + i + ']').prop('selected', true);
                        }
                    });
                }
            }
        }
    }

    /**
     * Сбор данных из select атрибутов
     *
     */
    static changeData() {
        var selected_attr = [];

        for (var x = 0; x < $('.selectattr').length; x++) {
            selected_attr.push($('.selectattr')[x]['selectedOptions'][0]['value']);
        }
        return selected_attr;
    }

    /**
     * Вывод атрибутов в товаре
     *
     */
    static add() {
        var attributesdata_edit_product = $('div#ajax_data').data('attributesdata');
        // Выводим атрибуты
        var group_attributes_data = $.parseJSON(attributesdata_edit_product['group_attributes']);
        var attributes_data = $.parseJSON(attributesdata_edit_product['attributes']);

        for (var x = 0; x < group_attributes_data.length; x++) {
            AttributesProcessing.addData(group_attributes_data[x][0], attributes_data[x], x);
        }

        $('#selected_attributes').val(JSON.stringify(AttributesProcessing.changeData()));
        $('.selectattr').change(function () {
            $('#selected_attributes').val(JSON.stringify(AttributesProcessing.changeData()));
        });
    }

}