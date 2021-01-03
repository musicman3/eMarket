<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Загрузка bootstrap-switch -->
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- Инициализация bootstrap-switch -->
<script type="text/javascript">
    $('#switch_active').bootstrapSwitch();
</script>
<!-- Отправка данных при переключении bootstrap-switch -->
<script type="text/javascript">
    $('#switch_active').on('switchChange.bootstrapSwitch', function (event, state) {
        var msg = $('#form_edit_active').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '?route=settings/modules',
            data: msg
        });
    });
</script>    

<script type="text/javascript">
    function callSaveMod(url) {
        var msg = $('#form_save_mod').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: url,
            data: msg
        });
        // Отправка запроса для обновления страницы
        jQuery.get(url,
                {},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            document.location.href = url;
        }
    }
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>