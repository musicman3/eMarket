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

    if ($('#server_db').val() !== '') {
        replaceClass('.server_db', true);
    }
    if ($('#login_db').val() !== '') {
        replaceClass('.login_db', true);
    }
    if ($('#database_name').val() !== '') {
        replaceClass('.database_name', true);
    }
    if ($('#password_db').val() !== '') {
        replaceClass('.password_db', true);
    }

    if ($('#email').val().match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
        replaceClass('.email', true);
    }

    $('#server_db').on('input', function () {
        if ($('#server_db').val() !== '') {
            replaceClass('.server_db', true);
        } else {
            replaceClass('.server_db', false);
        }
    });

    $('#login_db').on('input', function () {
        if ($('#login_db').val() !== '') {
            replaceClass('.login_db', true);
        } else {
            replaceClass('.login_db', false);
        }
    });

    $('#database_name').on('input', function () {
        if ($('#database_name').val() !== '') {
            replaceClass('.database_name', true);
        } else {
            replaceClass('.database_name', false);
        }
    });
    
    $('#password_db').on('input', function () {
        if ($('#password_db').val() !== '') {
            replaceClass('.password_db', true);
        } else {
            replaceClass('.password_db', false);
        }
    });

    $('#email').on('input', function () {
        var email = $('#email').val();
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            replaceClass('.email', false);
        } else {
            replaceClass('.email', true);
        }
    });

    $('#password_admin_confirm').on('input', function () {
        var password = $('#password_admin').val();
        var confirm = $('#password_admin_confirm').val();
        if (confirm === password && password.length > 6 && confirm.length > 6 && password.length < 41 && confirm.length < 41) {
            replaceClass('.confirm', true);
            replaceClass('.password', true);

        } else {
            replaceClass('.confirm', false);
            replaceClass('.password', false);
        }
    });

    function validate() {
        var password = $("#password_admin").val();
        var password_2 = $("#password_admin_confirm").val();
        var email = $('#email').get(0);
        var confirm = $("#password_admin_confirm").get(0);

        if (password !== password_2) {
            confirm.setCustomValidity("<?php echo lang('password_check') ?>");
        } else {
            confirm.setCustomValidity('');
        }

        //Если email не соответствует типу
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            email.setCustomValidity("<?php echo lang('email_check') ?>");
        } else {
            email.setCustomValidity('');
        }
    }

</script>