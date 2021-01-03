<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<script type="text/javascript">
    if ($("#smtp_status option:selected").val() === 'off') {
        $('#smtp_auth').attr('disabled', 'disabled');
        $('#host_email').attr('disabled', 'disabled');
        $('#username_email').attr('disabled', 'disabled');
        $('#password_email').attr('disabled', 'disabled');
        $('#smtp_secure').attr('disabled', 'disabled');
        $('#smtp_port').attr('disabled', 'disabled');
    }

    $('#smtp_status').change(function (event) {
        if ($("#smtp_status option:selected").val() === 'off') {
            $('#smtp_auth').attr('disabled', 'disabled');
            $('#host_email').attr('disabled', 'disabled');
            $('#username_email').attr('disabled', 'disabled');
            $('#password_email').attr('disabled', 'disabled');
            $('#smtp_secure').attr('disabled', 'disabled');
            $('#smtp_port').attr('disabled', 'disabled');
        } else {
            $('#smtp_auth').removeAttr('disabled');
            $('#host_email').removeAttr('disabled');
            $('#username_email').removeAttr('disabled');
            $('#password_email').removeAttr('disabled');
            $('#smtp_secure').removeAttr('disabled');
            $('#smtp_port').removeAttr('disabled');
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>