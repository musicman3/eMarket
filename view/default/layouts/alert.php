<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!--Выводим уведомление об успешном действии-->
<div style="text-align:center;padding:0;margin:0;float:right;line-height:1;" id="alert" class="alert text-<?php echo $a ?> fade in"  role="alert">
    <span class="glyphicon glyphicon-alert"></span> <?php echo $b ?>
</div>

<!--Автозакрытие уведомлений-->
<script>
    $(function () {
        window.setTimeout(function () {
            $('#alert').alert('close');
        }, 3000);
    });
</script>