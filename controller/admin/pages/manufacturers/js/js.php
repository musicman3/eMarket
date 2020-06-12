<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {

            // Получаем данные из data div
            var name = $('div#ajax_data').data('name');
            var site = $('div#ajax_data').data('site');
            var logo = $('div#ajax_data').data('logo');
            var logo_general = $('div#ajax_data').data('general');

            $('#edit').val(modal_id);
            $('#add').val('');

            // Ищем id и добавляем данные
            for (x = 0; x < name.length; x++) {
                $('#name_manufacturers_' + x).val(name[x][modal_id]);
            }
            $('#site_manufacturers').val(site[modal_id]);

            // Подгружаем изображения
            getImageToEdit(logo_general, logo, modal_id);
        } else {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $('.input-sm').val('');
        }
    });
</script>
<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>
<!--Подгружаем jQuery File Upload -->
<script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>
<?php
// Подгружаем jQuery File Upload
\eMarket\Ajax::fileUpload('', 'manufacturers', $resize_param);
?>