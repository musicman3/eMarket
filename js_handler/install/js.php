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

    if (document.querySelector('#server_db').value !== '') {
        replaceClass('.server_db', true);
    }
    if (document.querySelector('#login_db').value !== '') {
        replaceClass('.login_db', true);
    }
    if (document.querySelector('#database_name').value !== '') {
        replaceClass('.database_name', true);
    }
    if (document.querySelector('#password_db').value !== '') {
        replaceClass('.password_db', true);
    }

    if (document.querySelector('#email').value.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
        replaceClass('.email', true);
    }

    Helpers.on('input', 'on', '#server_db', function (e) {
        if (document.querySelector('#server_db').value !== '') {
            replaceClass('.server_db', true);
        } else {
            replaceClass('.server_db', false);
        }
    });

    Helpers.on('input', 'on', '#login_db', function (e) {
        if (document.querySelector('#login_db').value !== '') {
            replaceClass('.login_db', true);
        } else {
            replaceClass('.login_db', false);
        }
    });

    Helpers.on('input', 'on', '#database_name', function (e) {
        if (document.querySelector('#database_name').value !== '') {
            replaceClass('.database_name', true);
        } else {
            replaceClass('.database_name', false);
        }
    });

    Helpers.on('input', 'on', '#password_db', function (e) {
        if (document.querySelector('#password_db').value !== '') {
            replaceClass('.password_db', true);
        } else {
            replaceClass('.password_db', false);
        }
    });

    Helpers.on('input', 'on', '#email', function (e) {
        var email = document.querySelector('#email').value;
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            replaceClass('.email', false);
        } else {
            replaceClass('.email', true);
        }
    });

        Helpers.on('input', 'on', '#password_admin_confirm', function (e) {
        var password = document.querySelector('#password_admin').value;
        var confirm = document.querySelector('#password_admin_confirm').value;
        if (confirm === password && password.length > 6 && confirm.length > 6 && password.length < 41 && confirm.length < 41) {
            replaceClass('.confirm', true);
            replaceClass('.password', true);

        } else {
            replaceClass('.confirm', false);
            replaceClass('.password', false);
        }
    });

    function validate() {
        var password = document.querySelector("#password_admin").value;
        var password_2 = document.querySelector("#password_admin_confirm").value;
        var email = document.querySelector('#email');
        var confirm = document.querySelector("#password_admin_confirm");

        if (password !== password_2) {
            confirm.setCustomValidity("<?php echo lang('password_check') ?>");
        } else {
            confirm.setCustomValidity('');
        }

        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            email.setCustomValidity("<?php echo lang('email_check') ?>");
        } else {
            email.setCustomValidity('');
        }
    }

</script>