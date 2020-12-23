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
     * @param data {String} (данные по атрибутам)
     *
     */
    static add(marker, data, language) {
        var jsdata = new JsData();

        if (data.length > 0) {
            data = $.parseJSON($.parseJSON(data));
        }

        var group_attributes_data = jsdata.sort(jsdata.selectParentUids('false', data));
        var selected = $.parseJSON($('#selected_attributes').val());

        group_attributes_data.forEach((level_1) => {
            var level_length = level_1.length;
            var data_id = level_length - 1;
            
            for(var x = 0; x < level_length; x++){
                if (level_1[x]['name'] === 'group_attributes_' + language){
                    var lang = x;
                }
            }
            var level_2 = jsdata.sort(jsdata.selectParentUids(level_1[data_id]['uid'], data));

            var check = AttributesProcessing.checkSelect(data, selected, level_1[data_id]['uid']);

            if (marker === 'admin' && level_2[lang] !== undefined) {
                $('.product-attribute').prepend('<div class="panel panel-default"><div class="panel-heading"><h5 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#' + level_1[data_id]['uid'] + '">' + level_1[lang]['value'] + '</a></h5></div><div id="' + level_1[data_id]['uid'] + '" class="panel-collapse collapse"><div class="panel-body"><table class="table table-striped product-attribute-table"><tbody id="table_' + level_1[data_id]['uid'] + '"></tbody></table></div></div></div>');
            } else {
                if (check === 'true') {
                    $('.product-attribute').prepend('<h5>' + level_1[lang]['value'] + '</h5><table class="table table-striped product-attribute-table"><tbody id="table_' + level_1[data_id]['uid'] + '"></tbody></table>');
                }
            }

            level_2.forEach((item, index) => {
                var check = AttributesProcessing.checkSelect(data, selected, item[data_id]['uid']);
                var level_3 = jsdata.sort(jsdata.selectParentUids(item[data_id]['uid'], data));
                if (marker === 'admin') {

                    if (level_3[lang] !== undefined) {
                        var light = 'has-success';
                    } else {
                        var light = 'has-error';
                    }

                    $('#table_' + level_1[data_id]['uid']).prepend(
                            '<tr><td class="attribute"><span class="product-attribute-specification">' + item[lang]['value'] + '</span></td>' +
                            '<td class="selector"><div class="input-group ' + light + '"><span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>' +
                            '<select class="form-control selectattr" id="selectattr_' + item[data_id]['uid'] + '"></select></div></td></tr>'
                            );
                    $('#selectattr_' + item[data_id]['uid']).empty();
                    level_3.forEach((string, i) => {
                        $('#selectattr_' + item[data_id]['uid']).prepend($('<option></option>').val(string[data_id]['uid']).html(string[lang]['value']));
                        if (selected.length !== 0 && selected.includes(string[data_id]['uid']) === true) {
                            $('#selectattr_' + item[data_id]['uid'] + ' option[value=' + string[data_id]['uid'] + ']').prop('selected', true);
                        }
                    });
                } else {
                    if (check === 'true') {
                        $('#table_' + level_1[data_id]['uid']).prepend(
                                '<tr><td class="attribute"><span class="product-attribute-specification">' + item[lang]['value'] + '</span></td>' +
                                '<td class="selector"><div class="selectattr" id="selectattr_' + item[data_id]['uid'] + '"></div></td></tr>'
                                );
                        level_3.forEach((string, i) => {
                            if (selected.length !== 0 && selected.includes(string[data_id]['uid']) === true) {
                                $('#selectattr_' + item[data_id]['uid']).html(string[lang]['value']);
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
     * Сортировка
     * @param sortedIDs {Array} (список сортировки)
     * @param data_id {String} (data_id)
     * @returns {Array}
     *
     */
    sorted(sortedIDs, data_id) {
        var jsdata = new JsData();
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        var parse_attributes_sort = jsdata.selectParentUids(data_id, $.parseJSON(sessionStorage.getItem('attributes')));
        var sort = jsdata.sortToListUid(sortedIDs, parse_attributes_sort);

        var sorted = jsdata.replaceUids(sort, parse_attributes);

        sessionStorage.setItem('attributes', JSON.stringify(sorted));
        var parse_attributes_add = jsdata.selectParentUids(data_id, $.parseJSON(sessionStorage.getItem('attributes')));

        return parse_attributes_add;
    }

    /**
     * Проверка по выбранным значениям
     * @param data {Array} (Входящий массив)
     * @param selected {Array} (Массив с выбранными значениями)
     * @param uid {String} (uid)
     * @returns {Array}
     *
     */
    static checkSelect(data, selected, uid) {
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