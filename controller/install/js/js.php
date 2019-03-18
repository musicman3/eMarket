<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    function pass_check() {
        var password = $("#password_admin").val();
        var password_2 = $("#password_admin_confirm").val();
        if (password !== password_2) {
            alert("<?php echo lang('password_check') ?>");
            $('#password_admin').empty();
            $('#password_admin_confirm').empty();
            return false;
        }
        if (password.length < 5) {
            alert("<?php echo lang('password_lenght_min') ?>");
            $('#password_admin').empty();
            $('#password_admin_confirm').empty();
            return false;
        }
        if (password.length > 40) {
            alert("<?php echo lang('password_lenght_max') ?>");
            $('#password_admin').empty();
            $('#password_admin_confirm').empty();
            return false;
        }
    }

    function check() {
        var db_host = $('#server_db').val();
        var db_user = $('#login_db').val();
        var db_name = $('#database_name').val();
        var email = $('#email').val();

        //Если не заполнен Сервер БД
        if (db_host.length < 1) {
            alert("<?php echo lang('db_host_check') ?>");
            $('#server_db').empty();
            return false;
        }
        //Если не заполнен пользователь БД
        if (db_user.length < 1) {
            alert("<?php echo lang('db_user_check') ?>");
            $('#login_db').empty();
            return false;
        }
        //Если не заполнено имя БД
        if (db_name.length < 1) {
            alert("<?php echo lang('db_name_check') ?>");
            $('#database_name').empty();
            return false;
        }
        //Если email не соответствует типу
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            alert("<?php echo lang('email_check') ?>");
            $('#email').empty();
            return false;
        } else
        if (confirm("<?php echo lang('confirm_install') ?>"))
            document.forms.submit();
        return false;
    }
</script>