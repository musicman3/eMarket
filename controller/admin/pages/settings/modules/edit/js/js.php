<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('?route=settings/modules');

?>
<!-- Загрузка bootstrap-switch -->
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- Инициализация bootstrap-switch -->
<script type="text/javascript">
    $('#switch').bootstrapSwitch();
</script>
