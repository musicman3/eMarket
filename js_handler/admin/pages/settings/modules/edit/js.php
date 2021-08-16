<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    Helpers.on('body', 'click', '#switch_active', function (e) {
        document.querySelector('#alert_flag').value = 'off';
        var msg = document.forms.form_edit_active;
        let data = new FormData(msg);
        data.append('csrf_token', document.querySelector('#csrf_token').dataset.csrf);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '?route=settings/modules', false);
        xhr.send(data);
    });
</script>    

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>