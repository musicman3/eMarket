<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    Helpers.on('body', 'click', '#switch_active', function (e) {
        var msg = document.forms.form_edit_active;
        let data = new FormData(msg);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '?route=settings/modules', false);
        xhr.send(data);
    });
</script>    

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>