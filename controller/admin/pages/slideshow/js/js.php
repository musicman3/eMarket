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
</script>

<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>

