<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#default_stikers').bootstrapSwitch();
</script>
<!-- /Сортировка мышкой -->
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

        $("#sort-list").sortable({
            items: 'tr.sort-list',
            handle: '.sortyes',
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
                sortList();
            }
        });
    });

    function sortList() {
        var ids = [];
        $("#sort-list tr").each(function () {
            ids[ids.length] = $(this).attr('unitid');
        });
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.post(window.location.href,
                {ids: ids.join()});
        // Повторный вызов функции для нормального обновления страницы
        jQuery.get(window.location.href,
                {}, // id родительской категории
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#default_stikers').bootstrapSwitch('destroy');
        }
    }
</script>

<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            $('#default_stikers').bootstrapSwitch('destroy', true);
            // Получаем массивы данных
            var json_data = $('div#ajax_data').data('jsondata');

            $('#edit').val(modal_id);
            $('#add').val('');

            // Ищем id и добавляем данные
            for (x = 0; x < json_data['name'].length; x++) {
                $('#name_stikers_' + x).val(json_data['name'][x][modal_id]);
            }
            // Меняем значение чекбокса
            $('#default_stikers').prop('checked', json_data['status'][modal_id]);
            $('#default_stikers').bootstrapSwitch();
        } else {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');
            // Меняем значение чекбокса
            $('#default_stikers').prop('checked', '1');
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax('');
</script>