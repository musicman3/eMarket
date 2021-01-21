<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<script type="text/javascript">
    function replaceClass(nameClass, reverse = true) {
        if (reverse === true) {
            $(nameClass).removeClass('has-error');
            $(nameClass).addClass('has-success');
        } else {
            $(nameClass).removeClass('has-success');
            $(nameClass).addClass('has-error');
    }
    }

    $('.password-data').on('input', function () {
        var password = $('#password').val();
        var confirm = $('#confirm_password').val();
        if (confirm === password && password.length > 6 && confirm.length > 6 && password.length < 41 && confirm.length < 41) {
            replaceClass('.confirm', true);
            replaceClass('.password', true);
        } else {
            replaceClass('.confirm', false);
            replaceClass('.password', false);
        }
    });

    function validate() {
        var confirm = $('#confirm_password').get(0);

        if ($('#password').val() !== $('#confirm_password').val()) {
            confirm.setCustomValidity("<?php echo lang('my_account_password_check') ?>");
        } else {
            confirm.setCustomValidity('');
        }
    }

</script>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>