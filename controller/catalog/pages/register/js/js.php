<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

\eMarket\Other\Ajax::сart('');

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

    if ($('#input-firstname').val() !== '') {
        replaceClass('.firstname', true);
    }
    if ($('#input-lastname').val() !== '') {
        replaceClass('.lastname', true);
    }

    if ($('#input-email').val().match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
        replaceClass('.email', true);
    }

    $('#input-firstname').on('input', function () {
        if ($('#input-firstname').val() !== '') {
            replaceClass('.firstname', true);
        } else {
            replaceClass('.firstname', false);
        }
    });

    $('#input-lastname').on('input', function () {
        if ($('#input-lastname').val() !== '') {
            replaceClass('.lastname', true);
        } else {
            replaceClass('.lastname', false);
        }
    });

    $('#input-email').on('input', function () {
        var email = $('#input-email').val();
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            replaceClass('.email', false);
        } else {
            replaceClass('.email', true);
        }
    });

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
        var email = $('#input-email').get(0);
        if ($('#input-password').val() !== $('#input-confirm').val()) {
            confirm.setCustomValidity("<?php echo lang('password_check') ?>");
        } else {
            confirm.setCustomValidity('');
        }
        //Если email не соответствует типу
        if (!$('#input-email').val().match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            email.setCustomValidity("<?php echo lang('email_check') ?>");
        } else {
            email.setCustomValidity('');
        }
    }
</script>