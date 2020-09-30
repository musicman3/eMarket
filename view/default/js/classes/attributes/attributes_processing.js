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
            if ($('.selectattr')[x]['selectedOptions'] !== undefined && $('.selectattr')[x]['selectedOptions'].length > 0) {
                selected_attr.push($('.selectattr')[x]['selectedOptions'][0]['value']);
            }
        }

        return selected_attr;
    }

    /**
     * Вывод атрибутов в товаре
     * @param marker {String} (маркер admin/catalog)
     *
     */
    static add(marker = null) {
        var jsdata = new JsData();
        var attributesprocessing = new AttributesProcessing();

        var data = $.parseJSON($.parseJSON($('div#ajax_data').data('attributesdata')));
        var group_attributes_data = jsdata.sort(jsdata.selectParentUids('false', data));
        var selected = $.parseJSON($('#selected_attributes').val());

        group_attributes_data.forEach((level_1) => {
            var data_id = level_1.length - 1;
            var level_2 = jsdata.sort(jsdata.selectParentUids(level_1[data_id]['uid'], data));

            var check = attributesprocessing.checkSelect(data, selected, level_1[data_id]['uid']);

            if (marker === 'admin' && level_2[0] !== undefined) {
                $('.product-attribute').prepend('<h4>' + level_1[0]['value'] + '</h4><table class="table table-striped product-attribute-table"><tbody id="table_' + level_1[data_id]['uid'] + '"></tbody></table>');
            } else {
                if (check === 'true') {
                    $('.product-attribute').prepend('<h4>' + level_1[0]['value'] + '</h4><table class="table table-striped product-attribute-table"><tbody id="table_' + level_1[data_id]['uid'] + '"></tbody></table>');
                }
            }

            level_2.forEach((item, index) => {
                var check = attributesprocessing.checkSelect(data, selected, item[data_id]['uid']);
                var level_3 = jsdata.sort(jsdata.selectParentUids(item[data_id]['uid'], data));
                if (marker === 'admin') {

                    if (level_3[0] !== undefined) {
                        var light = 'has-success';
                    } else {
                        var light = 'has-error';
                    }
                    
                    $('#table_' + level_1[data_id]['uid']).prepend(
                            '<tr><td class="attribute"><span class="product-attribute-specification">' + item[0]['value'] + '</span></td>' +
                            '<td class="selector"><div class="input-group ' + light + '"><span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>' +
                            '<select class="form-control selectattr" id="selectattr_' + item[data_id]['uid'] + '"></select></div></td></tr>'
                            );
                    $('#selectattr_' + item[data_id]['uid']).empty();
                    level_3.forEach((string, i) => {
                        $('#selectattr_' + item[data_id]['uid']).prepend($('<option></option>').val(string[data_id]['uid']).html(string[0]['value']));
                        if (selected.length !== 0 && selected.includes(string[data_id]['uid']) === true) {
                            $('#selectattr_' + item[data_id]['uid'] + ' option[value=' + string[data_id]['uid'] + ']').prop('selected', true);
                        }
                    });
                } else {
                    if (check === 'true') {
                        $('#table_' + level_1[data_id]['uid']).prepend(
                                '<tr><td class="attribute"><span class="product-attribute-specification">' + item[0]['value'] + '</span></td>' +
                                '<td class="selector"><div class="selectattr" id="selectattr_' + item[data_id]['uid'] + '"></div></td></tr>'
                                );
                        level_3.forEach((string, i) => {
                            if (selected.length !== 0 && selected.includes(string[data_id]['uid']) === true) {
                                $('#selectattr_' + item[data_id]['uid']).html(string[0]['value']);
                            }
                        });
                    }
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

    /**
     * Проверка по выбранным значениям
     * @param data {Array} (Входящий массив)
     * @param selected {Array} (Массив с выбранными значениями)
     * @param uid {String} (uid)
     * @returns {Array}
     *
     */
    checkSelect(data, selected, uid) {
        var jsdata = new JsData();

        var recursive_data = jsdata.buildTree(data, uid);
        var mark = 'false';
        recursive_data.forEach((item) => {
            if (selected.includes(item) === true) {
                mark = 'true';
            }
        });
        return mark;
    }

}