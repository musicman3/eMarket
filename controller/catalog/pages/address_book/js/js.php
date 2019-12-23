<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#default').bootstrapSwitch();
</script>

<script type = "text/javascript">
    $('#countries').change(function (event) {
        jQuery.post('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                {countries_select: $("#countries").val()},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            var result = $.parseJSON(data);
           $("#regions").empty();
           
           for (x = 0; x < result.length; x++) {
                $("#regions").append( $('<option value="' + result[x]['id'] + '">' + result[x]['name'] + '</option>'));
            }
           
        }
    });
</script>