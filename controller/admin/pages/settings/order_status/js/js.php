<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#default_order_status').bootstrapSwitch();
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
        jQuery.post('?route=settings/order_status',
                {ids: ids.join()});
        // Повторный вызов функции для нормального обновления страницы
        jQuery.get('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                {}, // id родительской категории
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#ajax').html(data);
        }
    }
</script>

<?php if (isset($name_edit)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#edit').on('show.bs.modal', function (event) {
            $('#default_order_status_edit').bootstrapSwitch('destroy', true);
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            // Получаем массивы данных
            var name_edit = $('div#ajax_data').data('name');
            var order_status_edit = $('div#ajax_data').data('order_status');

            // Ищем id и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('#name_order_status_edit_' + x).val(name_edit[x][modal_id]);
            }

            $('#js_edit').val(modal_id);
            // Меняем значение чекбокса
            $('#default_order_status_edit').prop('checked', order_status_edit[modal_id]);
            $('#default_order_status_edit').bootstrapSwitch();
        });
    </script>
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>

