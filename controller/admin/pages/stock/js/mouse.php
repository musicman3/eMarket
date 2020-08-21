<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Сортировка мышкой -->
<script type="text/javascript">
    $(document).ready(function () {
        var start = function (e, ui) {
            let $originals = ui.helper.children();
            ui.placeholder.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
        };

        var helper = function (e, tr) {
            let $helper = tr.clone();
            let $originals = tr.children();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).outerWidth(true));
            });
            return $helper;
        };

        function sortInit(id, items, handle) {
            $(id).sortable({
                items: items,
                handle: handle,
                axis: "y",
                helper: helper,
                start: start,
                over: function (event, ui) {
                    ui.helper.css("opacity", "0.7"),
                            ui.helper.css("background-color", "#F5F5F5");
                },
                beforeStop: function (event, ui) {
                    ui.helper.css("opacity", "1.0"),
                            ui.helper.css("background-color", "");
                },
                stop: function (event, ui) {
                    if (id === '#sort-list') {
                        sortList();
                    }
                    if (id === '.group-attributes') {
                        sortGroupAttributes();
                    }
                    if (id === '.attribute') {
                        sortAttributes();
                    }
                    if (id === '.values_attribute') {
                        sortValueAttributes();
                    }
                }
            });
        }
        sortInit('#sort-list', 'tr.sort-list', 'td.sortyes');
        sortInit('.group-attributes', 'tr.groupattributes', 'td.sortyes-group');
        sortInit('.attribute', 'tr.attributes-class', 'td.sortyes-attributes');
        sortInit('.values_attribute', 'tr.value-attributes-class', 'td.sortyes-value-attributes');
    });

    function sortList() {
        var ids = [];
        $("#sort-list tr").each(function () {
            ids[ids.length] = $(this).attr('unitid');
        });
        $('.group-attributes').sortable('option', 'disabled', true);
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.post('?route=stock',
                {ids: ids.join()});
        // Повторный вызов функции для нормального обновления страницы
        jQuery.get('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                {}, // id родительской категории
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#view_categories_stock').bootstrapSwitch('destroy');
            $('#fileupload').fileupload('destroy');
            $('#fileupload-product').fileupload('destroy');
            $('#ajax').html(data);
            $('.group-attributes').sortable('option', 'disabled', false);
        }
    }

    function sortArrayAttributes(array, sort_list, split) {
        var new_array = [];
        sort_list.reverse();

        for (x = 0; x < array.length; x++) {
            new_array[x] = array[sort_list[x].split('_')[split] - 1];
        }

        return new_array;
    }

    function sortGroupAttributes() {
        var sortedIDs = $(".group-attributes").sortable("toArray");

        var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));
        var sort = sortArrayAttributes(parse_group_attributes, sortedIDs, 1);
        sessionStorage.setItem('group_attributes', JSON.stringify(sort));

        var parse_group_attributes_new = $.parseJSON(sessionStorage.getItem('group_attributes'));
        $('.group-attributes').empty();
        for (x = 0; x < parse_group_attributes_new.length; x++) {
            var y = x + 1;
            addGroupAttribute(y, parse_group_attributes_new[x][0]['value']);
        }
    }

    function sortAttributes() {
        var sortedIDs = $(".attribute").sortable("toArray");

        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        var group_id = sessionStorage.getItem('group_attribute_id');
        var sort = sortArrayAttributes(parse_attributes[group_id], sortedIDs, 1);
        parse_attributes[group_id] = sort;
        sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

        var parse_attributes_new = $.parseJSON(sessionStorage.getItem('attributes'));
        $('.attribute').empty();
        for (x = 0; x < parse_attributes_new[group_id].length; x++) {
            var y = x + 1;
            addAttribute(y, parse_attributes_new[group_id][x][0]['value']);
        }
    }

    function sortValueAttributes() {
        var sortedIDs = $(".values_attribute").sortable("toArray");

        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        var group_id = sessionStorage.getItem('group_attribute_id');

        var sort = sortArrayAttributes(parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'], sortedIDs, 2);
        parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'] = sort;
        sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

        var parse_attributes_new = $.parseJSON(sessionStorage.getItem('attributes'));
        $('.values_attribute').empty();
            for (x = 0; x < parse_attributes_new[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'].length; x++) {
                addValueAttribute(x + 1, parse_attributes_new[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'][x]);
            }
    }
</script>

<!-- Выбор мышкой -->
<script type="text/javascript">
    $(".option").click(function () {
        $(this).find('span').toggleClass('inactive');
        $(this).toggleClass('active');
    });
</script>