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
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- Bootstrap Datepicker" -->
<script type="text/javascript" src="/ext/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<link href="/ext/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script type="text/javascript" src="/ext/bootstrap-datepicker/locales/bootstrap-datepicker.<?php echo lang('meta-language') ?>.min.js"></script>
<script type="text/javascript" src="/model/js/classes/smartdatepicker.js"></script>
<!--Подгружаем jQuery File Upload -->
<script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/model/js/classes/images/fileupload.js"></script>

<script type="text/javascript">
    var resize_max = $.parseJSON('<?php echo $resize_max ?>');
    var lang = $.parseJSON('<?php echo $lang_js ?>');
    new Fileupload(resize_max, lang);

    $('#mouse_stop, #autostart, #cicles, #indicators, #navigation, #view_slideshow', '#animation').bootstrapSwitch();

    $('#settings').on('show.bs.modal', function (event) {
        $('#mouse_stop, #autostart, #cicles, #indicators, #navigation').bootstrapSwitch('destroy', true);
        // Получаем массивы данных
        var json_data = $('div#ajax_data').data('jsonsettings');

        $('#show_interval').val(json_data['show_interval']);

        // Меняем значение чекбокса
        $('#mouse_stop').prop('checked', Number(json_data['mouse_stop']));
        $('#autostart').prop('checked', Number(json_data['autostart']));
        $('#cicles').prop('checked', Number(json_data['cicles']));
        $('#indicators').prop('checked', Number(json_data['indicators']));
        $('#navigation').prop('checked', Number(json_data['navigation']));

        $('#mouse_stop, #autostart, #cicles, #indicators, #navigation').bootstrapSwitch();
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tab = e.target['hash'].slice(1);
        $('#set_language').val(tab);
        window.history.pushState(null, null, "?route=slideshow&slide_lang=" + tab);

        jQuery.get(window.location.href,
                {slide_lang: tab},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('.ajax-tab').replaceWith($(data).find('.ajax-tab'));
            $('#ajax_data').replaceWith($(data).find('#ajax_data'));
            $('[data-toggle=confirmation]').confirmation();
        }
    });

    $('#index').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            $('#view_slideshow, #animation').bootstrapSwitch('destroy', true);
            // Получаем массивы данных
            var json_data = $('div#ajax_data').data('jsondata');
            var start = json_data['date_start'][modal_id];
            var end = json_data['date_finish'][modal_id];

            $('#edit').val(modal_id);
            $('#add').val('');
            // Меняем значение чекбокса
            $('#view_slideshow').prop('checked', json_data['status'][modal_id]);
            $('#view_slideshow').prop('checked', 1);
            $('#view_slideshow, #animation').bootstrapSwitch();

            $('#url').val(json_data['url'][modal_id]);
            $('#name').val(json_data['name'][modal_id]);
            $('#heading').val(json_data['heading'][modal_id]);

            // Устанавливаем SmartDatepicker
            var day_start = new Date(start);
            $('#start_date').datepicker('setDate', day_start);
            $('#end_date').datepicker('setDate', new Date(end));
            if (day_start.setDate(day_start.getDate()) < new Date()) {
                $('#start_date').datepicker('setStartDate', new Date());
                $('#start_date').datepicker('setDate', new Date());
            }
            // Подгружаем изображения
            Fileupload.getImageToEdit(json_data['logo_general'], json_data['logo'], modal_id, 'slideshow');
        }
        if (!Number.isInteger(modal_id) && button.data('toggle') === 'modal') {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');
            // Меняем значение чекбокса
            $('#view_slideshow, #animation').prop('checked', '1');
            $('#view_slideshow, #animation').bootstrapSwitch();
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
    new SmartDatepicker('<?php echo lang('meta-language') ?>');
</script>