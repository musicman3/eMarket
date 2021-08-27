/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, confirmation, Helpers */

/**
 * Attributes
 *
 * @package Attributes
 * @author eMarket
 * 
 */
class Attributes {
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
     * Init for modals
     *
     *@param lang {Array} (lang)
     */
    modal(lang) {

        document.querySelector('#attribute').addEventListener('show.bs.modal', function (event) {

            var jsdata = new JsData();
            var data_id = sessionStorage.getItem('level_1');
            var parse_attributes = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));

            Attributes.add(lang, parse_attributes);
            Attributes.deleteValue(lang);

        });

        document.querySelector('#attribute').addEventListener('hidden.bs.modal', function (event) {
            document.querySelector('.attribute').innerHTML = '';
        });

    }

    /**
     * Init for clicks
     *
     *@param lang {Array} (lang)
     */
    click(lang) {
        Helpers.on('body', 'click', '.values-attribute', function (e) {
            var jsdata = new JsData();
            var data_id = e.target.closest('tr').dataset.id.split('_')[1];
            var parse_attributes = jsdata.selectParentUids(sessionStorage.getItem('level_1'), JSON.parse(sessionStorage.getItem('attributes')));
            sessionStorage.setItem('level_2', data_id);

            new bootstrap.Modal(document.querySelector('#values_attribute')).show();
            var level_length = parse_attributes[0].length;

            for (var x = 0; x < level_length; x++) {
                if (parse_attributes[0][x]['name'] === 'attribute_' + lang.translate_name) {
                    var language = x;
                }
            }

            document.querySelector('#title_values_attribute').innerHTML = jsdata.selectUid(data_id, parse_attributes)[language]['value'];
        });

        Helpers.on('body', 'click', '.add-attribute', function (e) {
            document.querySelector('#attribute_add_form').reset();
            new bootstrap.Modal(document.querySelector('#add_attribute')).show();
            sessionStorage.setItem('action', 'add');
        });

        Helpers.on('body', 'click', '.edit-attribute', function (e) {
            new bootstrap.Modal(document.querySelector('#add_attribute')).show();
            var processing = new AttributesProcessing();
            processing.clickEdit(e.target.closest('tr').id.split('_')[1], sessionStorage.getItem('level_1'), 'level_2');

        });

        Helpers.on('body', 'click', '#save_attribute_button', function (e) {
            bootstrap.Modal.getInstance(document.querySelector('#add_attribute')).hide();

            var attributes_bank = Helpers.serializeArray('#attribute_add_form');
            var data_id = sessionStorage.getItem('level_1');
            var jsdata = new JsData();
            var parse_attributes = JSON.parse(sessionStorage.getItem('attributes'));

            if (sessionStorage.getItem('action') === 'add') {
                var parse_attributes_add = jsdata.add(attributes_bank, parse_attributes, data_id);

                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_add));
                var parse_attributes_view = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                Attributes.add(lang, parse_attributes_view);
            }

            if (sessionStorage.getItem('action') === 'edit') {
                var id = sessionStorage.getItem('level_2');
                var parse_attributes_edit = jsdata.editUid(id, parse_attributes, attributes_bank);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_edit));
                var parse_attributes_view = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                Attributes.add(lang, parse_attributes_view);
            }

            document.querySelector('.input-add-attribute').value = '';
            Attributes.deleteValue(lang);
        });
    }

    /**
     * Add value
     *
     * @param id {String} (id)
     * @param value {String} (value)
     */
    static addValue(id, value) {
        document.querySelector('.attribute').insertAdjacentHTML('afterbegin',
                '<tr class="attributes-class align-middle" data-id="attributes_' + id + '" id="attributes_' + id + '">' +
                '<td class="sortyes sortleft-m bi-arrows-move"></td>' +
                '<td class="sortleft"><button type="button" class="values-attribute btn btn-primary btn-sm bi-gear"></button></td>' +
                '<td>' + value + '</td>' +
                '<td>' +
                '<div class="gap-2 d-flex justify-content-end"><button type="button" class="edit-attribute btn btn-primary btn-sm bi-pencil-square"></button>' +
                '<button type="button" class="delete-attribute btn btn-primary btn-sm bi-trash"></button></div>' +
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

        var buttons = document.querySelectorAll('.delete-attribute');
        buttons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                var elem = e.currentTarget;
                new bootstrap.Modal(document.querySelector('#confirm')).show();
                confirmation.onclick = function () {
                    bootstrap.Modal.getInstance(document.querySelector('#confirm')).hide();
                    elem.closest('tr').remove();

                    var jsdata = new JsData();
                    var data_id = sessionStorage.getItem('level_1');
                    var parse_attributes = JSON.parse(sessionStorage.getItem('attributes'));

                    var parse_attributes_delete = jsdata.deleteUid(elem.closest('tr').id.split('_')[1], parse_attributes);
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_delete));

                    var parse_attributes_add = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                    Attributes.add(lang, parse_attributes_add);
                    Attributes.deleteValue(lang);
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
        var parse_attributes_add = processing.sorted(sortedIDs, sessionStorage.getItem('level_1'));

        Attributes.add(lang, parse_attributes_add);
        Attributes.deleteValue(lang);
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

        document.querySelector('.attribute').innerHTML = '';
        parse.forEach((string, index) => {
            var sort_id = string.length - 1;
            string.forEach((item, i) => {
                if (item.name === 'attribute_' + lang.translate_name) {
                    Attributes.addValue(parse_attributes_sort[index][sort_id].uid, parse_attributes_sort[index][i].value);
                }
            });
        });
    }
}