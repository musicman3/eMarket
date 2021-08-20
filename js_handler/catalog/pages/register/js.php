<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<script type="text/javascript">
    function validate() {
        var confirm = document.querySelector('#input-confirm');
        var email = document.querySelector('#input-email');
        if (document.querySelector('#input-password').value !== document.querySelector('#input-confirm').value) {
            confirm.setCustomValidity('<?php echo lang('register_password_check') ?>');
        } else {
            confirm.setCustomValidity('');
        }
    }
</script>