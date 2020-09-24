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
     * @param group_attributes {Array} (Группа атрибутов)
     * @param attributes {Array} (Атрибуты)
     * @param group_number {String} (Номер группы атрибутов)
     * @param marker {String} (маркер)
     */
    static addData(group_attributes, attributes, group_number, marker) {
        var selected = $.parseJSON($('#selected_attributes').val());
        var selected_array = [];
        var out_array = [];

        for (var x = 0; x < selected.length; x++) {
            selected_array[x] = selected[x].split('_');
        }

        for (var x = 0; x < selected_array.length; x++) {
            if (Number(selected_array[x][0]) === group_number) {
                out_array.unshift(selected_array[x]);
            }
        }

        if (attributes !== undefined && attributes !== null) {
            $('.product-attribute').prepend('<h4>' + group_attributes['value'] + '</h4><table class="table table-striped product-attribute-table"><tbody id="table_' + group_number + '"></tbody></table>');
            for (var x = 0; x < attributes.length; x++) {
                if (attributes[x][0]['data'] !== undefined && attributes[x][0]['data'] !== null) {
                    if (marker === 'admin') {
                        $('#table_' + group_number).prepend(
                                '<tr><td class="attribute"><span class="product-attribute-specification">' + attributes[x][0]['value'] + '</span></td>' +
                                '<td class="selector"><div class="input-group has-success"><span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>' +
                                '<select class="form-control selectattr" id="selectattr_' + group_number + '_' + x + '"></select></div></td></tr>'
                                );
                        $('#selectattr_' + group_number + '_' + x).empty();
                        attributes[x][0]['data'].reverse();
                        $.each(attributes[x][0]['data'], function (i, p) {
                            $('#selectattr_' + group_number + '_' + x).append($('<option></option>').val(group_number + '_' + x + '_' + i).html(p));
                            if (out_array.length !== 0 && i === Number(out_array[x][2])) {
                                $('#selectattr_' + group_number + '_' + x + ' option[value=' + group_number + '_' + x + '_' + i + ']').prop('selected', true);
                            }
                        });

                    } else {
                        if (out_array.length !== 0) {
                            $('#table_' + group_number).prepend(
                                    '<tr><td class="attribute"><span class="product-attribute-specification">' + attributes[x][0]['value'] + '</span></td>' +
                                    '<td class="selector"><div class="selectattr" id="selectattr_' + group_number + '_' + x + '"></div></td></tr>'
                                    );
                            attributes[x][0]['data'].reverse();
                            $.each(attributes[x][0]['data'], function (i, p) {
                                if (i === Number(out_array[x][2])) {
                                    $('#selectattr_' + group_number + '_' + x).html(p);
                                }
                            });
                        }
                    }
                }
            }
        }
    }

    /**
     * Сбор данных из select атрибутов
     * @returns {Array}
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
     * @param marker {String} (маркер)
     *
     */
    static add(marker = null) {
        var attributesdata_edit_product = $('div#ajax_data').data('attributesdata');
        // Выводим атрибуты
        var group_attributes_data = $.parseJSON(attributesdata_edit_product['group_attributes']);
        var attributes_data = $.parseJSON(attributesdata_edit_product['attributes']);
        var arr = AttributesProcessing.sortList(group_attributes_data);
        
        for (var x = 0; x < group_attributes_data.length; x++) {
            var arr_id = arr[x]['id'];
            if (marker === null) {
                AttributesProcessing.addData(group_attributes_data[arr_id][0], attributes_data[arr_id], arr_id);
            } else {
                AttributesProcessing.addData(group_attributes_data[arr_id][0], attributes_data[arr_id], arr_id, marker);
            }
        }

        $('#selected_attributes').val(JSON.stringify(AttributesProcessing.changeData()));
        $('.selectattr').change(function () {
            $('#selected_attributes').val(JSON.stringify(AttributesProcessing.changeData()));
        });
    }
    
    /**
     * Листинг для сортировки
     * 
     * @param parse_group_attributes {Array} (Входящий массив)
     * @returns {Array}
     *
     */
    static sortList(parse_group_attributes) {

        var arr = [];

        for (var x = 0; x < parse_group_attributes.length; x++) {
            var sort_id = parse_group_attributes[x].length - 1 ;
            arr.push({id: x, sort: parse_group_attributes[x][sort_id]['sort']});
        }

        arr.sort(function (a, b) {
            return a.sort - b.sort;
        });
        return arr;
    }    

}