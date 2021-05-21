<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!--Выводим уведомление об успешном действии-->
<div id="alert" class="alert alert-<?php echo $_SESSION['message'][0] ?> fade show bi-exclamation-triangle"> <?php echo $_SESSION['message'][1] ?></div>

<!--Автозакрытие уведомлений-->
<script>
    var time = <?php echo $_SESSION['message'][2] ?>;
    window.setTimeout(function () {
        new bootstrap.Alert(document.querySelector('#alert')).close();
    }, time);
</script>