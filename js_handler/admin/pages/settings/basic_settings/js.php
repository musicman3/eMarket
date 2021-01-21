<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    if (document.querySelector('#smtp_status').options.selectedIndex === 1) {
        disableInput();
    }

    document.querySelector('#smtp_status').addEventListener('change', function (event) {
        if (document.querySelector('#smtp_status').options.selectedIndex === 1) {
            disableInput();
        } else {
            document.querySelector('#smtp_auth').removeAttribute('disabled');
            document.querySelector('#host_email').removeAttribute('disabled');
            document.querySelector('#username_email').removeAttribute('disabled');
            document.querySelector('#password_email').removeAttribute('disabled');
            document.querySelector('#smtp_secure').removeAttribute('disabled');
            document.querySelector('#smtp_port').removeAttribute('disabled');
        }
    });

    function disableInput() {
        document.querySelector('#smtp_auth').setAttribute('disabled', 'disabled');
        document.querySelector('#host_email').setAttribute('disabled', 'disabled');
        document.querySelector('#username_email').setAttribute('disabled', 'disabled');
        document.querySelector('#password_email').setAttribute('disabled', 'disabled');
        document.querySelector('#smtp_secure').setAttribute('disabled', 'disabled');
        document.querySelector('#smtp_port').setAttribute('disabled', 'disabled');
    }
</script>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>