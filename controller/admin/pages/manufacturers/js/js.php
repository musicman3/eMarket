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
            
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            // Получаем массивы данных
            var name_edit = <?php echo $name_edit ?>;
            var site_edit = <?php echo $site_edit ?>;
            var logo_edit = <?php echo $logo_edit ?>;

            // Ищем классы и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('.name_edit' + x).val(name_edit[x][modal_id]);
            }
            $('.site_edit').val(site_edit[modal_id]);
            $('.js_edit').val(modal_id);

            // Ищем классы и добавляем данные
            for (x = 0; x < logo_edit[modal_id].length; x++) {
                $('#logo-edit').append('<span class="file-upload-edit"><img src="/downloads/images/manufacturers/resize/' + logo_edit[modal_id][x] + '" /> </span>'); // Вставляем лого
            }

        });
    </script>
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('/controller/admin/pages/manufacturers/index.php');
// Подгружаем jQuery File Upload
$AJAX->fileUpload();
// Отправляем POST на удаление временных файлов при открытии модального окна
$AJAX->fileUploadEmpty('/controller/admin/pages/manufacturers/index.php');

?>