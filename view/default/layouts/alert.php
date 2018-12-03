<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!--Выводим уведомление об успешном действии-->
<div style="text-align:center;padding-top:0px;padding-bottom:0px;margin-bottom:0;float:right;" id="alert" class="alert alert-<?php echo $a ?> fade in" role="alert">
    <span class="glyphicon glyphicon-alert"></span> <?php echo $b ?>
</div>

<!--Автозакрытие уведомлений-->
<script>
    $(function () {
        window.setTimeout(function () {
            $('#alert').alert('close');
        }, 300000);
    });
</script>