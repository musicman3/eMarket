/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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
        this.modal(lang);
        this.click(lang);
    }

    /**
     * Init for modals
     *
     *@param lang {Array} (lang)
     */
    modal(lang) {

        $('#attribute').on('show.bs.modal', function (event) {

            var jsdata = new JsData();
            var data_id = sessionStorage.getItem('level_1');
            var parse_attributes = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));

            Attributes.add(lang, parse_attributes);
            Attributes.deleteValue(lang);

        });

        $('#attribute').on('hidden.bs.modal', function (event) {
            $('.attribute').empty();
        });

        $('#add_attribute').on('hidden.bs.modal', function (event) {
            $('.input-add-attribute').val('');
            Attributes.deleteValue(lang);
        });
    }

    /**
     * Init for clicks
     *
     *@param lang {Array} (lang)
     */
    click(lang) {
        $(document).on('click', '.values-attribute', function () {
            var jsdata = new JsData();
            var data_id = $(this).closest('tr').attr('id').split('_')[1];
            var parse_attributes = jsdata.selectParentUids(sessionStorage.getItem('level_1'), JSON.parse(sessionStorage.getItem('attributes')));
            sessionStorage.setItem('level_2', data_id);

            $('#values_attribute').modal('show');
            var level_length = parse_attributes[0].length;
            
            for(var x = 0; x < level_length; x++){
                if (parse_attributes[0][x]['name'] === 'attribute_' + lang[4]){
                    var language = x;
                }
            }

            $('#title_values_attribute').html(jsdata.selectUid(data_id, parse_attributes)[language]['value']);
        });

        $(document).on('click', '.add-attribute', function () {
            sessionStorage.setItem('action', 'add');
            $('#add_attribute').modal('show');
        });

        $(document).on('click', '.edit-attribute', function () {
            $('#add_attribute').modal('show');
            var processing = new AttributesProcessing();
            processing.clickEdit($(this).closest('tr').attr('id').split('_')[1], sessionStorage.getItem('level_1'), 'level_2');

        });

        $('#save_attribute_button').click(function () {
            $('#add_attribute').modal('hide');

            var attributes_bank = $('#attribute_add_form').serializeArray();
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

            $('.input-add-attribute').val('');
        });
    }

    /**
     * Add value
     *
     * @param id {String} (id)
     * @param value {String} (value)
     * @param lang {Array} (lang)
     */
    static addValue(id, value, lang) {
        $('.attribute').prepend(
                '<tr class="attributes-class" id="attributes_' + id + '">' +
                '<td class="sortyes-attributes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>' +
                '<td class="sortleft-m"><button type="button" class="values-attribute btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></button></td>' +
                '<td>' + value + '</td>' +
                '<td>' +
                '<div class="flexbox"><div class="b-left"><button type="button" class="edit-attribute btn btn-primary btn-xs" title="' + lang[3] + '"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '<div><button type="button" class="delete-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="' + lang[0] + '" data-btn-cancel-label="' + lang[1] + '" title="' + lang[2] + '"><span class="glyphicon glyphicon-trash"> </span></button></div></div>' +
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
        $('.delete-attribute').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event) {
                $(this).closest('tr').remove();

                var jsdata = new JsData();
                var data_id = sessionStorage.getItem('level_1');
                var parse_attributes = JSON.parse(sessionStorage.getItem('attributes'));

                var parse_attributes_delete = jsdata.deleteUid($(this).closest('tr').attr('id').split('_')[1], parse_attributes);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes_delete));

                var parse_attributes_add = jsdata.selectParentUids(data_id, JSON.parse(sessionStorage.getItem('attributes')));
                Attributes.add(lang, parse_attributes_add);
                Attributes.deleteValue(lang);
            }});
    }

    /**
     * Sorting
     * 
     * @param lang {Array} (lang)
     *
     */
    sort(lang) {
        var sortedIDs = $(".attribute").sortable("toArray").reverse();
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

        $('.attribute').empty();
        parse.forEach((string, index) => {
            var sort_id = string.length - 1;
            string.forEach((item, i) => {
                if (item.name === 'attribute_' + lang[4]) {
                    Attributes.addValue(parse_attributes_sort[index][sort_id].uid, parse_attributes_sort[index][i].value, lang);
                }
            });
        });
    }
}