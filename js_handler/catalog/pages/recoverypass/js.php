<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<script type="text/javascript">

    function replaceClass(nameClass, reverse = true) {
        if (reverse === true) {
            document.querySelector(nameClass).classList.remove('is-invalid');
            document.querySelector(nameClass).classList.add('is-valid');
        } else {
            document.querySelector(nameClass).classList.remove('is-valid');
            document.querySelector(nameClass).classList.add('is-invalid');
    }
    }
    
    Helpers.on('input', 'on', '#input-confirm', function (e) {
        var password = document.querySelector('#input-password').value;
        var confirm = document.querySelector('#input-confirm').value;
        if (confirm === password && password.length > 6 && confirm.length > 6 && password.length < 41 && confirm.length < 41) {
            replaceClass('.confirm', true);
            replaceClass('.password', true);
        } else {
            replaceClass('.confirm', false);
            replaceClass('.password', false);
        }
    });
    
        function validate() {
        var confirm = document.querySelector('#input-confirm');
        if (document.querySelector('#input-password').value !== document.querySelector('#input-confirm').value) {
            confirm.setCustomValidity('<?php echo lang('register_password_check') ?>');
                } else {
                    confirm.setCustomValidity('');
                }
            }
</script>