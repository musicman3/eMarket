<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#mouse_stop').bootstrapSwitch();
    $('#autostart').bootstrapSwitch();
    $('#cicles').bootstrapSwitch();
    $('#indicators').bootstrapSwitch();
    $('#navigation').bootstrapSwitch();
    $('#view_slideshow').bootstrapSwitch();

    $('#settings').on('show.bs.modal', function (event) {
        $('#mouse_stop').bootstrapSwitch('destroy', true);
        $('#autostart').bootstrapSwitch('destroy', true);
        $('#cicles').bootstrapSwitch('destroy', true);
        $('#indicators').bootstrapSwitch('destroy', true);
        $('#navigation').bootstrapSwitch('destroy', true);
        // Получаем массивы данных
        var json_data = $('div#ajax_data').data('jsonsettings');

        $('#show_interval').val(json_data['show_interval']);

        // Меняем значение чекбокса
        $('#mouse_stop').prop('checked', Number(json_data['mouse_stop']));
        $('#autostart').prop('checked', Number(json_data['autostart']));
        $('#cicles').prop('checked', Number(json_data['cicles']));
        $('#indicators').prop('checked', Number(json_data['indicators']));
        $('#navigation').prop('checked', Number(json_data['navigation']));

        $('#mouse_stop').bootstrapSwitch();
        $('#autostart').bootstrapSwitch();
        $('#cicles').bootstrapSwitch();
        $('#indicators').bootstrapSwitch();
        $('#navigation').bootstrapSwitch();
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tab = e.target['hash'].slice(1);
        $('#slide_language').val(tab);
        window.history.pushState(null, null, "?route=slideshow&slide_lang=" + tab);

        jQuery.get(window.location.href,
                {slide_lang: tab},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('.ajax-tab').replaceWith($(data).find('.ajax-tab'));
            $('[data-toggle=confirmation]').confirmation();
        }
    });

    $('#index').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            $('#default_stikers').bootstrapSwitch('destroy', true);
            // Получаем массивы данных
            var json_data = $('div#ajax_data').data('jsondata');

            $('#edit').val(modal_id);
            $('#add').val('');

            // Меняем значение чекбокса
            //$('#view_slideshow').prop('checked', json_data['status'][modal_id]);
            //$('#view_slideshow').bootstrapSwitch();
        } else {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');
            // Меняем значение чекбокса
            $('#view_slideshow').prop('checked', '1');
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>