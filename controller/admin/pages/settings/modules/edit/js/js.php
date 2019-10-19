<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action(\eMarket\Valid::inSERVER('REQUEST_URI'));
?>
<!-- Загрузка bootstrap-switch -->
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- Инициализация bootstrap-switch -->
<script type="text/javascript">
    $('#switch').bootstrapSwitch();
</script>
<!-- Отправка данных при переключении bootstrap-switch -->
<script type="text/javascript">
    $('#switch').on('switchChange.bootstrapSwitch', function (event, state) {
        var msg = $('#form_edit').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '?route=settings/modules',
            data: msg
        });
    });
</script>    