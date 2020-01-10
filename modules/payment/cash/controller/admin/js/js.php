<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!--Мультиселект-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#example-buttonClass-buttonTitle-selectAllJustVisible-xss-html-collapseOptGroupsByDefault-buttonText-selectAllText-collapsedClickableOptGroups-includeSelectAllOption').multiselect({
            //Выбирать группы
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            collapseOptGroupsByDefault: true,
            //Включить "Выбрать все"
            includeSelectAllOption: true,
            //Надписи "Выбрать все"
            selectAllText: '<?php echo lang('select_all') ?>',
            //"Выбрать все" для раскрытых и не раскрытых стран
            selectAllJustVisible: false,
            //Включить поддержку HTML в названиях
            enableHTML: true,
            //Класс на кнопку
            buttonClass: 'btn btn-primary',

            //Свой Title на кнопке
            buttonTitle: function () {
                return 'Выберите модуль доставки';
            },

            //Надписи на кнопке
            buttonText: function (options, select) {
                if (options.length === 0) {
                    return 'Выберите модуль доставки';
                } else if (options.length > 0) {
                    return '<?php echo lang('positions_selected') ?>: ' + options.length + ' <?php echo lang('pcs') ?>';
                } else {
                    var labels = [];
                    options.each(function () {
                        if ($(this).attr('label') !== undefined) {
                            labels.push($(this).attr('label'));
                        } else {
                            labels.push($(this).html());
                        }
                    });
                    return labels.join(', ') + '';
                }
            }

        });
    });
</script>

<?php
if (isset($shipping_zone_edit)) {
    ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#edit').on('show.bs.modal', function (event) {
            $('#default_module_edit').bootstrapSwitch('destroy', true);
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            if (modal_id === undefined) {
                modal_id = $('#js_edit').val();
            }
            // Получаем массивы данных
            var zone_edit = $('div#ajax_data').data('zone');
            var minimum_price_edit = $('div#ajax_data').data('price');

            $('#zone_edit').val(zone_edit[modal_id]);
            $('#minimum_price_edit').val(minimum_price_edit[modal_id]);
            $('#js_edit').val(modal_id);
        });
    </script>
    <?php
}

// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>


