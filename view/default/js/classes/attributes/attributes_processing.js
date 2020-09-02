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
class AttributesProcessing {

    /**
     * Инициализация для модалов
     *
     * @param group_attributes array (Группа атрибутов)
     * @param attributes array (Атрибуты)
     * @param x string (Номер группы атрибутов)
     */
    static addDataAttributes(group_attributes, attributes, x) {
        $('.product-attribute').prepend(
                '<h4>' + group_attributes['value'] + '</h4><table class="table table-striped product-attribute-table"><tbody id="table_' + x + '"></tbody></table>'
                );

        if (attributes !== undefined && attributes !== null) {
            for (var y = 0; y < attributes.length; y++) {
                if (attributes[y][0]['data'] !== undefined && attributes[y][0]['data'] !== null) {
                    $('#table_' + x).prepend(
                            '<tr><td><span class="product-attribute-specification">' + attributes[y][0]['value'] + '</span></td>' +
                            '<td><span class="product-attribute-specification pull-right"><select id="selectattr_' + x + '_' + y + '"></select></span></td></tr>'
                            );

                    $('#selectattr_' + x + '_' + y).empty();
                    attributes[y][0]['data'].reverse();
                    $.each(attributes[y][0]['data'], function (i, p) {
                        $('#selectattr_' + x + '_' + y).append($('<option></option>').val(x + '_' + y + '_' + i).html(p));
                    });
                }
            }
        }

    }
}