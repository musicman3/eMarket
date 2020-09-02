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

        if (attributes !== undefined && attributes !== null) {
            for (var y = 0; y < attributes.length; y++) {
                if (attributes[y][0]['data'] !== undefined && attributes[y][0]['data'] !== null) {
                    $('#table_' + group_number).prepend(
                            '<tr><td><span class="product-attribute-specification">' + attributes[y][0]['value'] + '</span></td>' +
                            '<td><span class="product-attribute-specification pull-right"><select id="selectattr_' + group_number + '_' + y + '"></select></span></td></tr>'
                            );

                    $('#selectattr_' + group_number + '_' + y).empty();
                    attributes[y][0]['data'].reverse();
                    $.each(attributes[y][0]['data'], function (i, p) {
                        $('#selectattr_' + group_number + '_' + y).append($('<option></option>').val(group_number + '_' + y + '_' + i).html(p));
                    });
                }
            }
        }

    }
}