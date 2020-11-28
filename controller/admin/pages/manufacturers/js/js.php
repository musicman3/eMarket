<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$resize_max = json_encode(\eMarket\Files::imgResizeMax($resize_param));
$lang_js = json_encode([
    'image_resize_error' => lang('image_resize_error'),
    'download_complete' => lang('download_complete')
        ]);
?>
<!--Подгружаем jQuery File Upload -->
<script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/model/js/classes/images/fileupload.js"></script>
<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>

<script type="text/javascript">
    var resize_max = $.parseJSON('<?php echo $resize_max ?>');
    var lang = $.parseJSON('<?php echo $lang_js ?>');
    new Fileupload(resize_max, lang);
    new Ajax();
    
    $('#index').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {

            var json_data = $('div#ajax_data').data('jsondata');

            $('#edit').val(modal_id);
            $('#add').val('');

            // Ищем id и добавляем данные
            for (x = 0; x < json_data['name'].length; x++) {
                $('#name_manufacturers_' + x).val(json_data['name'][x][modal_id]);
            }
            $('#site_manufacturers').val(json_data['site'][modal_id]);

            // Подгружаем изображения
            Fileupload.getImageToEdit(json_data['logo_general'], json_data['logo'], modal_id, 'manufacturers');
        } else {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');
        }
    });
</script>