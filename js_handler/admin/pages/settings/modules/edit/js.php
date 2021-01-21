<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<script type="text/javascript">
    $('#switch_active').bootstrapSwitch();
    $('#switch_active').on('switchChange.bootstrapSwitch', function (event, state) {
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