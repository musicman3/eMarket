<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
if (isset($_SESSION['message'][2])) {
    $time = $_SESSION['message'][2];
} else {
    $time = 3000;
}

?>
<!--Выводим уведомление об успешном действии-->
<div id="alert" class="alert text-<?php echo $_SESSION['message'][0] ?> fade in" role="alert">
    <span class="glyphicon glyphicon-alert"></span> <?php echo $_SESSION['message'][1] ?>
</div>

<!--Автозакрытие уведомлений-->
<script>
    $(function () {
        var time = <?php echo $time ?>;
        window.setTimeout(function () {
            $('#alert').alert('close');
        }, time);
    });
</script>