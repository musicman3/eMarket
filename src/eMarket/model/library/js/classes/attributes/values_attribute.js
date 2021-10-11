/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, confirmation, Helpers */

/**
 * Values Attributes
 *
 * @package Values Attributes
 * @author eMarket
 * 
 */
class ValuesAttribute {
    /**
     * Constructor
     *
     * @param lang {Json} (lang)
     */
    constructor(lang) {
        if (lang !== undefined) {
            this.modal(lang);
            this.click(lang);
        }
    }

    /**
     * Init for modal
     *
     *@param lang {Array} (lang)
     */
    modal(lang) {

        document.querySelector('#values_attribute').addEventListener('show.bs.modal', function (event) {

            var jsdata = new JsData();
            var data_id = sessionStorage.getItem('level_2');
            var parse_attributes = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));

            ValuesAttribute.add(lang, parse_attributes);
            ValuesAttribute.deleteValue(lang);

        });

        document.querySelector('#values_attribute').addEventListener('hidden.bs.modal', function (event) {
            document.querySelector('.values_attribute').innerHTML = '';
        });

    }

    /**
     * Init for clicks
     *
     *@param lang {Array} (lang)
     */
    click(lang) {
        Helpers.on('body', 'click', '.add-values-attribute', function (e) {
            document.querySelector('#add_values_attribute_form').reset();
            new bootstrap.Modal(document.querySelector('#add_values_attribute')).show();
            sessionStorage.setItem('action', 'add');
        });

        Helpers.on('body', 'click', '.edit-value-attribute', function (e) {
            new bootstrap.Modal(document.querySelector('#add_values_attribute')).show();
            var processing = new AttributesProcessing();
            processing.clickEdit(e.target.closest('tr').dataset.id.split('_')[1], sessionStorage.getItem('level_2'), 'level_3');

        });

        Helpers.on('body', 'click', '#save_add_values_attribute', function (e) {
            bootstrap.Modal.getInstance(document.querySelector('#add_values_attribute')).hide();

            var attributes_bank = Helpers.serializeArray('#add_values_attribute_form');
            var data_id = sessionStorage.getItem('level_2');
            var jsdata = new JsData();
            var parse_attributes = JSON.parse(sessionStorage.getItem('attributes'));

            if (sessionStorage.getItem('action') === 'add') {
                var parse_attributes_add = jsdata.add(attributes_bank, parse_attributes, data_id);

                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_add));
                var parse_attributes_view = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                ValuesAttribute.add(lang, parse_attributes_view);
            }

            if (sessionStorage.getItem('action') === 'edit') {
                var id = sessionStorage.getItem('level_3');
                var parse_attributes_edit = jsdata.editUid(id, parse_attributes, attributes_bank);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_edit));
                var parse_attributes_view = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                ValuesAttribute.add(lang, parse_attributes_view);
            }

            document.querySelector('.input-add-values-attribute').value = '';
            ValuesAttribute.deleteValue(lang);
        });

    }

    /**
     * Add value
     *
     * @param id {String} (string id)
     * @param value {String} (string value)
     */
    static addValue(id, value) {
        document.querySelector('.values_attribute').insertAdjacentHTML('afterbegin',
                '<tr class="value-attributes-class align-middle" data-id="valueattributes_' + id + '" id="valueattributes_' + id + '">' +
                '<td class="sortyes sortleft-m bi-arrows-move"></td>' +
                '<td>' + value + '</td>' +
                '<td>' +
                '<div class="gap-2 d-flex justify-content-end"><button type="button" class="edit-value-attribute btn btn-primary btn-sm bi-pencil-square"></button>' +
                '<button type="button" class="delete-value-attribute btn btn-primary btn-sm bi-trash"></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    /**
     * Delete
     * 
     * @param lang {Array} (lang)
     *
     */
    static deleteValue(lang) {

        var buttons = document.querySelectorAll('.delete-value-attribute');
        buttons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                var elem = e.currentTarget;
                new bootstrap.Modal(document.querySelector('#confirm')).show();
                confirmation.onclick = function () {
                    bootstrap.Modal.getInstance(document.querySelector('#confirm')).hide();
                    elem.closest('tr').remove();

                    var jsdata = new JsData();
                    var data_id = sessionStorage.getItem('level_2');
                    var parse_attributes = JSON.parse(sessionStorage.getItem('attributes'));

                    var parse_attributes_delete = jsdata.deleteUid(elem.closest('tr').id.split('_')[1], parse_attributes);
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_delete));

                    var parse_attributes_add = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                    ValuesAttribute.add(lang, parse_attributes_add);
                    ValuesAttribute.deleteValue(lang);
                };
            });
        });
    }

    /**
     * Sorting
     * 
     * @param lang {Array} (lang)
     * @param sortable {Object} (sortable)
     *
     */
    sort(lang, sortable) {
        var sortedIDs = sortable.toArray().reverse();
        var processing = new AttributesProcessing();
        var parse_attributes_add = processing.sorted(sortedIDs, sessionStorage.getItem('level_2'));

        ValuesAttribute.add(lang, parse_attributes_add);
        ValuesAttribute.deleteValue(lang);
    }

    /**
     * Add
     * 
     * @param lang {Array} (lang)
     * @param parse {Array} (attributes data)
     *
     */
    static add(lang, parse) {

        var jsdata = new JsData();
        var parse_attributes_sort = jsdata.sort(parse);

        document.querySelector('.values_attribute').innerHTML = '';
        parse.forEach((string, index) => {
            var sort_id = string.length - 1;
            string.forEach((item, i) => {
                if (item.name === 'add_values_attribute_' + lang.translate_name) {
                    ValuesAttribute.addValue(parse_attributes_sort[index][sort_id].uid, parse_attributes_sort[index][i].value);
                }
            });
        });
    }
}