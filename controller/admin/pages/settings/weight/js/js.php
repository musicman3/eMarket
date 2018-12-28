<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<?php if (isset($name_edit)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript" language="javascript">
        $('#edit').on('show.bs.modal', function (event) {
            var modal = $(this);
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            // Получаем массивы данных
            var name_edit = <?php echo $name_edit ?>;
            var code_edit = <?php echo $code_edit ?>;
            var value_weight_edit = <?php echo $value_weight_edit ?>;
            var status = <?php echo $status_weight_edit ?>;

            // Ищем классы и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                modal.find('.name_edit' + x).val(name_edit[x][modal_id]);
                modal.find('.code_edit' + x).val(code_edit[x][modal_id]);
            }

            modal.find('.value_weight_edit').val(value_weight_edit[modal_id]);
            modal.find('.js_edit').val(modal_id);
            // Меняем значение чекбокса
            $('#status_weight_edit').prop('checked', status[modal_id]);
        });
    </script>
<?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('/controller/admin/pages/settings/weight/index.php');
?>

