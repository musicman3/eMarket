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
     * Сбор данных из select атрибутов
     * @returns {Array}
     *
     */
    static changeData() {
        var selected_attr = [];
        
        for (var x = 0; x < $('.selectattr').length; x++) {
            if ($('.selectattr')[x]['selectedOptions'].length > 0) {
                selected_attr.push($('.selectattr')[x]['selectedOptions'][0]['value']);
            }
        }

        return selected_attr;
    }

    /**
     * Вывод атрибутов в товаре
     * @param marker {String} (маркер)
     *
     */
    static add(marker = null) {
        var jsdata = new JsData();

        var data = $.parseJSON($.parseJSON($('div#ajax_data').data('attributesdata')));
        var group_attributes_data = jsdata.sort(jsdata.selectParentUids('false', data));
        var selected = $.parseJSON($('#selected_attributes').val());

        group_attributes_data.forEach((level_1) => {
            var data_id = level_1.length - 1;
            if (marker === 'admin') {
                $('.product-attribute').prepend('<h4>' + level_1[0]['value'] + '</h4><table class="table table-striped product-attribute-table"><tbody id="table_' + level_1[data_id]['uid'] + '"></tbody></table>');
            } else {
                $('.product-attribute').prepend('<h4>' + level_1[0]['value'] + '</h4><table class="table table-striped product-attribute-table"><tbody id="table_' + level_1[data_id]['uid'] + '"></tbody></table>');
            }
            var level_2 = jsdata.sort(jsdata.selectParentUids(level_1[data_id]['uid'], data));

            level_2.forEach((item2, index) => {
                var level_3 = jsdata.sort(jsdata.selectParentUids(item2[data_id]['uid'], data));
                if (marker === 'admin') {
                    $('#table_' + level_1[data_id]['uid']).prepend(
                            '<tr><td class="attribute"><span class="product-attribute-specification">' + item2[0]['value'] + '</span></td>' +
                            '<td class="selector"><div class="input-group has-success"><span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>' +
                            '<select class="form-control selectattr" id="selectattr_' + item2[data_id]['uid'] + '"></select></div></td></tr>'
                            );

                    $('#selectattr_' + item2[data_id]['uid']).empty();
                    level_3.forEach((string, i) => {
                        $('#selectattr_' + item2[data_id]['uid']).prepend($('<option></option>').val(string[data_id]['uid']).html(string[0]['value']));
                        if (selected.length !== 0 && selected.includes(string[data_id]['uid']) === true) {
                            $('#selectattr_' + item2[data_id]['uid'] + ' option[value=' + string[data_id]['uid'] + ']').prop('selected', true);
                        }
                    });
                } else {
                    $('#table_' + level_1[data_id]['uid']).prepend(
                            '<tr><td class="attribute"><span class="product-attribute-specification">' + item2[0]['value'] + '</span></td>' +
                            '<td class="selector"><div class="selectattr" id="selectattr_' + item2[data_id]['uid'] + '"></div></td></tr>'
                            );
                    level_3.forEach((string, i) => {
                        if (selected.length !== 0 && selected.includes(string[data_id]['uid']) === true) {
                            $('#selectattr_' + item2[data_id]['uid']).html(string[0]['value']);
                        }
                    });
                }
            });
        });

        $('#selected_attributes').val(JSON.stringify(AttributesProcessing.changeData()));
        $('.selectattr').change(function () {
            $('#selected_attributes').val(JSON.stringify(AttributesProcessing.changeData()));
        });
    }

    /**
     * Отображение данных в окне редактирования атрибутов
     * @param id {String} (id)
     * @param uid {String} (uid)
     * @param name {String} (name)
     * @returns {Array}
     *
     */
    clickEdit(id, uid, name) {
        var jsdata = new JsData();

        var parse_attributes = jsdata.selectParentUids(uid, $.parseJSON(sessionStorage.getItem('attributes')));
        var uid_string = jsdata.selectUid(id, parse_attributes);

        sessionStorage.setItem('action', 'edit');
        sessionStorage.setItem(name, id);

        for (var x = 0; x < uid_string.length - 1; x++) {
            $('input[name="' + uid_string[x]['name'] + '"]').val(uid_string[x]['value']);
        }
    }

}