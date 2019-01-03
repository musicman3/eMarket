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
        var logo_general_edit = $('div#ajax_data').data('general');

        // Ищем классы и добавляем данные
        for (x = 0; x < name_edit.length; x++) {
            $('#name_edit' + x).val(name_edit[x][modal_id]);
        }
        $('#site_edit').val(site_edit[modal_id]);
        $('#js_edit').val(modal_id);

        // Добавляем данные
        for (x = 0; x < logo_edit[modal_id].length; x++) {
            var image = logo_edit[modal_id][x];

            $('<span class="file-upload" id="image_edit_' + x + '"/>').html('<div class="holder"><img src="/downloads/images/manufacturers/resize/' + image + '" class="thumbnail" id="general_' + x + '" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="delete_image_' + x + '" onclick="deleteImageEdit(\'' + image + '\', \'' + modal_id + '\', \'' + x + '\')"><span class="glyphicon glyphicon-trash"></span></button> <button class="btn btn-primary btn-xs" type="button" name="image_general_edit' + x + '" onclick="imageGeneralEdit(\'' + image + '\', \'' + modal_id + '\', \'' + x + '\')"><span class="glyphicon glyphicon-star"></span></button></div></div>').appendTo('#logo-edit'); // Вставляем лого
            // Если это главное изображение, то выделяем его
            if (logo_general_edit[modal_id] === image) {
                $('#general_' + x).addClass('img-active');
            }
        }

    });
</script>
<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('/controller/admin/pages/manufacturers/index.php');
// Подгружаем jQuery File Upload
$AJAX->fileUpload('/controller/admin/pages/manufacturers/index.php');

?>