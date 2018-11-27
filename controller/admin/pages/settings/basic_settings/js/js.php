<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!--Автозакрытие уведомлений-->
<script>
    $(function(){
        window.setTimeout(function(){
            $('#my-alert').alert('close');
        },3000);
    });
</script>