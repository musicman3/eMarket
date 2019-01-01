<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript" language="javascript">
    $('#edit').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования

        // Получаем данные из data div
        var name_edit = $('div#ajax_data').data('name');
        var site_edit = $('div#ajax_data').data('site');
        var logo_edit = $('div#ajax_data').data('logo');

        // Ищем классы и добавляем данные
        for (x = 0; x < name_edit.length; x++) {
            $('#name_edit' + x).val(name_edit[x][modal_id]);
        }
        $('#site_edit').val(site_edit[modal_id]);
        $('#js_edit').val(modal_id);

        // Ищем классы и добавляем данные
        for (x = 0; x < logo_edit[modal_id].length; x++) {
            var image = logo_edit[modal_id][x];
            $('<span/>').html('<span class="file-upload" id="image_edit_' + x + '"><div class="holder"><img src="/downloads/images/manufacturers/resize/' + image + '" class="thumbnail" height="60" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="delete_image_' + x + '" onclick="delete_image_edit(\'' + image + '\', \'' + modal_id + '\', \'' + x + '\')"><span class="glyphicon glyphicon-trash"></span></button></div></div> </span>').appendTo('#logo-edit'); // Вставляем лого
        }

    });
</script>
<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('/controller/admin/pages/manufacturers/index.php');
// Подгружаем jQuery File Upload
$AJAX->fileUpload('/controller/admin/pages/manufacturers/index.php');

?>