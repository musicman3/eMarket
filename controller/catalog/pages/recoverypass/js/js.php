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

    $('#input-confirm').on('input', function () {
        var password = $('#input-password').val();
        var confirm = $('#input-confirm').val();
        if (confirm === password && password.length > 6 && confirm.length > 6 && password.length < 41 && confirm.length < 41) {
            replaceClass('.confirm', true);
            replaceClass('.password', true);
        } else {
            replaceClass('.confirm', false);
            replaceClass('.password', false);
        }
    });

    function validate() {
        var confirm = $('#input-confirm').get(0);
        if ($('#input-password').val() !== $('#input-confirm').val()) {
            confirm.setCustomValidity("<?php echo lang('password_check') ?>");
        } else {
            confirm.setCustomValidity('');
        }
    }
</script>