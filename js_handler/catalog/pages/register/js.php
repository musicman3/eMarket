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

    if (document.querySelector('#input-firstname').value !== '') {
        replaceClass('.firstname', true);
    }
    if (document.querySelector('#input-lastname').value !== '') {
        replaceClass('.lastname', true);
    }

    if (document.querySelector('#input-email').value.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
        replaceClass('.email', true);
    }

    Helpers.on('input', 'on', '#input-firstname', function (e) {
        if (document.querySelector('#input-firstname').value !== '') {
            replaceClass('.firstname', true);
        } else {
            replaceClass('.firstname', false);
        }
    });

    Helpers.on('input', 'on', '#input-lastname', function (e) {
        if (document.querySelector('#input-lastname').value !== '') {
            replaceClass('.lastname', true);
        } else {
            replaceClass('.lastname', false);
        }
    });

    Helpers.on('input', 'on', '#input-email', function (e) {
        var email = document.querySelector('#input-email').value;
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            replaceClass('.email', false);
        } else {
            replaceClass('.email', true);
        }
    });

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
        var email = document.querySelector('#input-email');
        if (document.querySelector('#input-password').value !== document.querySelector('#input-confirm').value) {
            confirm.setCustomValidity('<?php echo lang('register_password_check') ?>');
        } else {
            confirm.setCustomValidity('');
        }
        if (!document.querySelector('#input-email').value.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            email.setCustomValidity("<?php echo lang('register_email_check') ?>");
        } else {
            email.setCustomValidity('');
        }
    }
</script>