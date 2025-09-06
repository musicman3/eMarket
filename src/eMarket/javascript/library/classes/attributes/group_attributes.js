/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global Helpers, bootstrap, confirmation */

/**
 * Attribute group
 *
 * @package Group Attributes
 * @author eMarket
 * 
 */
class GroupAttributes {
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

        document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
            var jsdata = new JsData();
            var data_id = 'false';
            if (sessionStorage.getItem('attributes') === null) {
                sessionStorage.setItem('attributes', '[]');
            }
            var parse_attributes = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));

            GroupAttributes.add(lang, parse_attributes);
            GroupAttributes.deleteValue(lang);
        });

        document.querySelector('#index').addEventListener('hidden.bs.modal', function (event) {
            GroupAttributes.clearAttributes();
        });

        document.querySelector('#index_product').addEventListener('hidden.bs.modal', function (event) {
            document.querySelector('.product-attribute').innerHTML = '';
        });
    }

    /**
     * Init for clicks
     *
     *@param lang {Array} (lang)
     */
    click(lang) {
        Helpers.on('body', 'click', '.values-group-attribute', function (e) {
            var jsdata = new JsData();
            var data_id = e.target.closest('tr').dataset.id.split('_')[1];
            var parse_attributes = jsdata.selectParentUids('false', JSON.parse(sessionStorage.getItem('attributes')));
            sessionStorage.setItem('level_1', data_id);

            new bootstrap.Modal(document.querySelector('#attribute')).show();
            var level_length = parse_attributes[0].length;

            for (var x = 0; x < level_length; x++) {
                if (parse_attributes[0][x]['name'] === 'group_attributes_' + lang.translate_name) {
                    var language = x;
                }
            }

            document.querySelector('#title_attribute').innerHTML = jsdata.selectUid(data_id, parse_attributes)[language]['value'];
        });

        Helpers.on('body', 'click', '.add-group-attributes', function (e) {
            document.querySelector('#group_attributes_add_form').reset();
            new bootstrap.Modal(document.querySelector('#add_group_attributes')).show();
            sessionStorage.setItem('action', 'add');
        });

        Helpers.on('body', 'click', '.edit-group-attribute', function (e) {
            new bootstrap.Modal(document.querySelector('#add_group_attributes')).show();
            var processing = new AttributesProcessing();
            processing.clickEdit(e.target.closest('tr').id.split('_')[1], 'false', 'level_1');
        });

        Helpers.on('body', 'click', '#save_group_attributes_button', function (e) {
            bootstrap.Modal.getInstance(document.querySelector('#add_group_attributes')).hide();

            var attributes_bank = Helpers.serializeArray('#group_attributes_add_form');
            var data_id = 'false';
            var jsdata = new JsData();
            var parse_attributes = JSON.parse(sessionStorage.getItem('attributes'));

            if (sessionStorage.getItem('action') === 'add') {
                var parse_attributes_add = jsdata.add(attributes_bank, parse_attributes, data_id);

                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_add));
                var parse_attributes_view = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                GroupAttributes.add(lang, parse_attributes_view);
            }

            if (sessionStorage.getItem('action') === 'edit') {
                var id = sessionStorage.getItem('level_1');
                var parse_attributes_edit = jsdata.editUid(id, parse_attributes, attributes_bank);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_edit));
                var parse_attributes_view = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                GroupAttributes.add(lang, parse_attributes_view);
            }

            GroupAttributes.deleteValue(lang);
        });
    }

    /**
     * Add value
     *
     * @param id {String} (string id)
     * @param value {String} (string value)
     */
    static addValue(id, value) {
        document.querySelector('.group-attributes').insertAdjacentHTML('afterbegin',
                '<tr class="groupattributes align-middle" data-id="groupattributes_' + id + '" id="groupattributes_' + id + '">' +
                '<td class="sortyes sortleft-m bi-arrows-move"></td>' +
                '<td class="sortleft"><button type="button" class="values-group-attribute btn btn-primary btn-sm bi-gear"></button></td>' +
                '<td>' + value + '</td>' +
                '<td>' +
                '<div class="gap-2 d-flex justify-content-end"><button type="button" class="edit-group-attribute btn btn-primary btn-sm bi-pencil-square"></button>' +
                '<button type="button" class="delete-group-attribute btn btn-primary btn-sm bi-trash"></button></div>' +
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
        var buttons = document.querySelectorAll('.delete-group-attribute');
        buttons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                var elem = e.currentTarget;
                new bootstrap.Modal(document.querySelector('#confirm')).show();
                confirmation.onclick = function () {
                    bootstrap.Modal.getInstance(document.querySelector('#confirm')).hide();
                    elem.closest('tr').remove();

                    var jsdata = new JsData();
                    var data_id = 'false';
                    var parse_attributes = JSON.parse(sessionStorage.getItem('attributes'));

                    var parse_attributes_delete = jsdata.deleteUid(elem.closest('tr').id.split('_')[1], parse_attributes);
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_delete));

                    var parse_attributes_add = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                    GroupAttributes.add(lang, parse_attributes_add);
                    GroupAttributes.deleteValue(lang);
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
        var parse_attributes_add = processing.sorted(sortedIDs, 'false');

        GroupAttributes.add(lang, parse_attributes_add);
        GroupAttributes.deleteValue(lang);
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

        document.querySelector('.group-attributes').innerHTML = '';
        parse.forEach((string, index) => {
            var sort_id = string.length - 1;
            string.forEach((item, i) => {
                if (item.name === 'group_attributes_' + lang.translate_name) {
                    GroupAttributes.addValue(parse_attributes_sort[index][sort_id].uid, parse_attributes_sort[index][i].value);
                }
            });
        });
    }

    /**
     * Clear Attributes
     *
     */
    static clearAttributes() {
        ['attributes',
            'level_1',
            'level_2',
            'level_3',
            'action'
        ].forEach((item) => sessionStorage.removeItem(item));
    }
}