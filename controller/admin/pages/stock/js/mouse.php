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
                        GroupAttributes.sortGroupAttributes(lang);
                    }
                    if (id === '.attribute') {
                        Attributes.sortAttributes(lang);
                    }
                    if (id === '.values_attribute') {
                        ValuesAttribute.sortValueAttributes(lang);
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
        $('.attribute').sortable('option', 'disabled', true);
        $('.values_attribute').sortable('option', 'disabled', true);
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
            $('.attribute').sortable('option', 'disabled', false);
            $('.values_attributes').sortable('option', 'disabled', false);
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