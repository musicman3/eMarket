<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!--Выводим уведомление об успешном действии-->
<div align="center" id="alert" class="alert alert-<?php echo $a ?> alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span class="back glyphicon glyphicon-alert"></span> <?php echo $b ?>
</div>

<!--Автозакрытие уведомлений-->
<script>
    $(function () {
        window.setTimeout(function () {
            $('#alert').alert('close');
        }, 30000);
    });
</script>