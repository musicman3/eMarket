<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    function validate() {
        var confirm = document.querySelector('#confirm_password');
        if (document.querySelector('#password').value !== document.querySelector('#confirm_password').value) {
            confirm.setCustomValidity('<?php echo lang('my_account_password_check') ?>');
        } else {
            confirm.setCustomValidity('');
        }
    }
</script>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>