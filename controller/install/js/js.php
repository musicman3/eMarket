<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    if ($('#server_db').val() !== '') {
        $('.server_db').removeClass('has-error');
        $('.server_db').addClass('has-success');
    }
    if ($('#login_db').val() !== '') {
        $('.login_db').removeClass('has-error');
        $('.login_db').addClass('has-success');
    }
    if ($('#database_name').val() !== '') {
        $('.database_name').removeClass('has-error');
        $('.database_name').addClass('has-success');
    }

    if ($('#email').val().match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
        $('.email').removeClass('has-error');
        $('.email').addClass('has-success');
    }

    $('#server_db').on('input', function () {
        if ($('#server_db').val() !== '') {
            $('.server_db').removeClass('has-error');
            $('.server_db').addClass('has-success');
        } else {
            $('.server_db').removeClass('has-success');
            $('.server_db').addClass('has-error');
        }
    });

    $('#login_db').on('input', function () {
        if ($('#login_db').val() !== '') {
            $('.login_db').removeClass('has-error');
            $('.login_db').addClass('has-success');
        } else {
            $('.login_db').removeClass('has-success');
            $('.login_db').addClass('has-error');
        }
    });

    $('#database_name').on('input', function () {
        if ($('#database_name').val() !== '') {
            $('.database_name').removeClass('has-error');
            $('.database_name').addClass('has-success');
        } else {
            $('.database_name').removeClass('has-success');
            $('.database_name').addClass('has-error');
        }
    });

    $('#email').on('input', function () {
        var email = $('#email').val();
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            $('.email').removeClass('has-success');
            $('.email').addClass('has-error');
        } else {
            $('.email').removeClass('has-error');
            $('.email').addClass('has-success');
        }
    });

    $('#password_admin_confirm').on('input', function () {
        var password = $('#password_admin').val();
        var confirm = $('#password_admin_confirm').val();
        if ($('#password_admin_confirm').val() === $('#password_admin').val() && password.length > 6 && confirm.length > 6 && password.length < 41 && confirm.length < 41) {
            $('.confirm').removeClass('has-error');
            $('.confirm').addClass('has-success');
            $('.password').removeClass('has-error');
            $('.password').addClass('has-success');

        } else {
            $('.confirm').removeClass('has-success');
            $('.confirm').addClass('has-error');
            $('.password').removeClass('has-success');
            $('.password').addClass('has-error');
        }
    });

    function validatePassword() {
        var password = $("#password_admin").val();
        var password_2 = $("#password_admin_confirm").val();

        var db_host = $('#server_db').val();
        var db_user = $('#login_db').val();
        var db_name = $('#database_name').val();
        var email = $('#email').val();

        if (password !== password_2) {
            document.getElementById("password_admin_confirm").setCustomValidity("<?php echo lang('password_check') ?>");
        } else {
            document.getElementById("password_admin_confirm").setCustomValidity('');
        }

        //Если не заполнен Сервер БД
        if (db_host.length < 1) {
            document.getElementById("server_db").setCustomValidity("<?php echo lang('db_host_check') ?>");
        } else {
            document.getElementById("server_db").setCustomValidity('');
        }
        //Если не заполнен пользователь БД
        if (db_user.length < 1) {
            document.getElementById("login_db").setCustomValidity("<?php echo lang('db_user_check') ?>");
        } else {
            document.getElementById("login_db").setCustomValidity('');
        }
        //Если не заполнено имя БД
        if (db_name.length < 1) {
            document.getElementById("database_name").setCustomValidity("<?php echo lang('db_name_check') ?>");
        } else {
            document.getElementById("database_name").setCustomValidity('');
        }
        //Если email не соответствует типу
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            document.getElementById("email").setCustomValidity("<?php echo lang('email_check') ?>");
        } else {
            document.getElementById("email").setCustomValidity('');
        }
    }

</script>