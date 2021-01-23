/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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
        this.modal(lang);
        this.click(lang);
    }

    /**
     * Init for modal
     *
     *@param lang {Array} (lang)
     */
    modal(lang) {

        $('#values_attribute').on('show.bs.modal', function (event) {

            var jsdata = new JsData();
            var data_id = sessionStorage.getItem('level_2');
            var parse_attributes = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));

            ValuesAttribute.add(lang, parse_attributes);
            ValuesAttribute.deleteValue(lang);

        });

        $('#values_attribute').on('hidden.bs.modal', function (event) {
            $('.values_attribute').empty();
        });

        $('#add_values_attribute').on('hidden.bs.modal', function (event) {
            $('.input-add-values-attribute').val('');
            ValuesAttribute.deleteValue(lang);
        });
    }

    /**
     * Init for clicks
     *
     *@param lang {Array} (lang)
     */
    click(lang) {

        $(document).on('click', '.add-values-attribute', function () {
            $('#add_values_attribute').modal('show');
            sessionStorage.setItem('action', 'add');
        });

        $(document).on('click', '.edit-value-attribute', function () {
            $('#add_values_attribute').modal('show');
            var processing = new AttributesProcessing();
            processing.clickEdit($(this).closest('tr').attr('id').split('_')[1], sessionStorage.getItem('level_2'), 'level_3');

        });

        $(document).on('click', '#save_add_values_attribute', function () {
            $('#add_values_attribute').modal('hide');

            var attributes_bank = $('#add_values_attribute_form').serializeArray();
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

            $('.input-add-values-attribute').val('');
        });

    }

    /**
     * Add value
     *
     * @param id {String} (string id)
     * @param value {String} (string value)
     * @param lang {Array} (lang)
     */
    static addValue(id, value, lang) {
        $('.values_attribute').prepend(
                '<tr class="value-attributes-class" id="valueattributes_' + id + '">' +
                '<td class="sortyes-value-attributes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>' +
                '<td>' + value + '</td>' +
                '<td>' +
                '<div class="flexbox"><div class="b-left"><button type="button" class="edit-value-attribute btn btn-primary btn-xs" title="' + lang[3] + '"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '<div><button type="button" class="delete-value-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="' + lang[0] + '" data-btn-cancel-label="' + lang[1] + '" title="' + lang[2] + '"><span class="glyphicon glyphicon-trash"> </span></button></div></div>' +
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
        $('.delete-value-attribute').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event) {
                $(this).closest('tr').remove();

                var jsdata = new JsData();
                var data_id = sessionStorage.getItem('level_2');
                var parse_attributes = JSON.parse(sessionStorage.getItem('attributes'));

                var parse_attributes_delete = jsdata.deleteUid($(this).closest('tr').attr('id').split('_')[1], parse_attributes);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_delete));

                var parse_attributes_add = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                ValuesAttribute.add(lang, parse_attributes_add);
                ValuesAttribute.deleteValue(lang);
            }});
    }

    /**
     * Sorting
     * 
     * @param lang {Array} (lang)
     *
     */
    sort(lang) {
        var sortedIDs = $(".values_attribute").sortable("toArray").reverse();
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

        $('.values_attribute').empty();
        parse.forEach((string, index) => {
            var sort_id = string.length - 1;
            string.forEach((item, i) => {
                if (item.name === 'add_values_attribute_' + lang[4]) {
                    ValuesAttribute.addValue(parse_attributes_sort[index][sort_id].uid, parse_attributes_sort[index][i].value, lang);
                }
            });
        });
    }
}