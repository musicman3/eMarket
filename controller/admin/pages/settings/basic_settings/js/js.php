<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('?route=settings/basic_settings');
?>

<script type="text/javascript">
    var smtp_status = <?php echo $smtp_status ?>;
    if (smtp_status === 0) {
        $('#smtp_auth').attr('disabled', 'disabled');
        $('#host_email').attr('disabled', 'disabled');
        $('#username_email').attr('disabled', 'disabled');
        $('#password_email').attr('disabled', 'disabled');
        $('#smtp_secure').attr('disabled', 'disabled');
        $('#smtp_port').attr('disabled', 'disabled');
    }else{
        
    }
</script>