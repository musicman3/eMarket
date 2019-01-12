<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#edit').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования

        // Получаем данные из data div
        var name_edit = $('div#ajax_data').data('name');
        var site_edit = $('div#ajax_data').data('site');
        var logo_edit = $('div#ajax_data').data('logo');
        var logo_general_edit = $('div#ajax_data').data('general');

        // Ищем классы и добавляем данные
        for (x = 0; x < name_edit.length; x++) {
            $('#name_edit' + x).val(name_edit[x][modal_id]);
        }
        $('#site_edit').val(site_edit[modal_id]);
        $('#js_edit').val(modal_id);
        
        // Подгружаем изображения
        getImageToEdit(logo_general_edit, logo_edit, modal_id);

    });
</script>
<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('/controller/admin/pages/manufacturers/index.php');
// Подгружаем jQuery File Upload
$AJAX->fileUpload('/controller/admin/pages/manufacturers/index.php', $resize_param);

?>