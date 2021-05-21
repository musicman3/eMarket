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

    Helpers.on('input', 'on', '.password-data', function (e) {
        var password = document.querySelector('#password').value;
        var confirm = document.querySelector('#confirm_password').value;
        if (confirm === password && password.length > 6 && confirm.length > 6 && password.length < 41 && confirm.length < 41) {
            replaceClass('.confirm', true);
            replaceClass('.password', true);
        } else {
            replaceClass('.confirm', false);
            replaceClass('.password', false);
        }
    });

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