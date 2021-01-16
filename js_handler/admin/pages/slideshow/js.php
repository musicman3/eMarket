<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$resize_max = json_encode(\eMarket\Core\Files::imgResizeMax(\eMarket\Admin\Slideshow::$resize_param));
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
<!-- jQuery File Upload -->
<script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/model/js/classes/images/fileupload.js"></script>

<script type="text/javascript">
    var resize_max = JSON.parse('<?php echo $resize_max ?>');
    var lang = JSON.parse('<?php echo $lang_js ?>');
    new Fileupload(resize_max, lang);

    $('#mouse_stop, #autostart, #cicles, #indicators, #navigation, #view_slideshow', '#animation').bootstrapSwitch();

    $('#settings').on('show.bs.modal', function (event) {
        $('#mouse_stop, #autostart, #cicles, #indicators, #navigation').bootstrapSwitch('destroy', true);
        var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsonsettings);

        document.querySelector('#show_interval').value = json_data.show_interval;

        document.querySelector('#mouse_stop').checked = Number(json_data.mouse_stop);
        document.querySelector('#autostart').checked = Number(json_data.autostart);
        document.querySelector('#cicles').checked = Number(json_data.cicles);
        document.querySelector('#indicators').checked = Number(json_data.indicators);
        document.querySelector('#navigation').checked = Number(json_data.navigation);

        $('#mouse_stop, #autostart, #cicles, #indicators, #navigation').bootstrapSwitch();
    });

    $('[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tab = e.target['hash'].slice(1);
        document.querySelector('#set_language').value = tab;
        window.history.pushState(null, null, "?route=slideshow&slide_lang=" + tab);

        let xhr = new XMLHttpRequest();
        xhr.open('GET', window.location.href, false);
        xhr.send({slide_lang: tab});
        if (xhr.status === 200) {
            var data = xhr.response;
            var dataXHR = document.createElement('div');
            dataXHR.innerHTML = data;
            document.querySelector('.ajax-tab').replaceWith(dataXHR.querySelector('.ajax-tab'));
            document.querySelector('#ajax_data').replaceWith(dataXHR.querySelector('#ajax_data'));
            $('[data-toggle=confirmation]').confirmation({rootSelector: '[data-toggle=confirmation]'});
        }
    });

    $('#index').on('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var modal_id = Number(button.dataset.edit);
        if (Number.isInteger(modal_id)) {
            $('#view_slideshow, #animation').bootstrapSwitch('destroy', true);
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);

            document.querySelector('#edit').value = modal_id;
            document.querySelector('#add').value = '';

            var start = json_data.date_start[modal_id];
            var end = json_data.date_finish[modal_id];
            document.querySelector('#view_slideshow').checked = json_data.status[modal_id];
            document.querySelector('#animation').checked = json_data.animation[modal_id];
            $('#view_slideshow, #animation').bootstrapSwitch();

            document.querySelector('#color').value = json_data.color[modal_id];
            document.querySelector('#url').value = json_data.url[modal_id];
            document.querySelector('#name').value = json_data.name[modal_id];
            document.querySelector('#heading').value = json_data.heading[modal_id];

            var day_start = new Date(start);
            $('#start_date').datepicker('setDate', day_start);
            $('#end_date').datepicker('setDate', new Date(end));

            if (day_start.setDate(day_start.getDate()) < new Date()) {
                $('#start_date').datepicker('setStartDate', new Date());
                $('#start_date').datepicker('setDate', new Date());
            }

            Fileupload.getImageToEdit(json_data.logo_general, json_data.logo, modal_id, 'slideshow');
        }
        if (!Number.isInteger(modal_id) && button.dataset.toggle === 'modal') {
            document.querySelector('#edit').value = '';
            document.querySelector('#add').value = 'ok';
            document.querySelector('form').reset();
            $('#view_slideshow, #animation').bootstrapSwitch();
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
    new SmartDatepicker('<?php echo lang('meta-language') ?>');
</script>