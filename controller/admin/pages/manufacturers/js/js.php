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
            var site_edit = <?php echo $site_edit ?>;

            // Ищем классы и меняем данные
            for (x = 0; x < name_edit.length; x++) {
                modal.find('.name_edit' + x).val(name_edit[x][modal_id]);
            }
            modal.find('.site_edit').val(site_edit[modal_id]);
            modal.find('.js_edit').val(modal_id);
        });
    </script>
<?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('/controller/admin/pages/manufacturers/index.php');
?>

