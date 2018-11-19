<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<script type="text/javascript">
    function pass_check() {
        var password = document.getElementById("password_admin").value;
        var password_2 = document.getElementById("password_admin_confirm").value;
        if (password != password_2)
        {
            alert("<?php echo lang('password_check') ?>");
            document.getElementById('password_admin').value = "";
            document.getElementById('password_admin_confirm').value = "";
            return false;
        }
        if (password.length < 5)
        {
            alert("<?php echo lang('password_lenght_min') ?>");
            document.getElementById('password_admin').value = "";
            document.getElementById('password_admin_confirm').value = "";
            return false;
        }
        if (password.length > 40)
        {
            alert("<?php echo lang('password_lenght_max') ?>");
            document.getElementById('password_admin').value = "";
            document.getElementById('password_admin_confirm').value = "";
            return false;
        }
    }

    function check(value) {
        var db_host = document.getElementById("server_db").value;
        var db_user = document.getElementById("login_db").value;
        var db_name = document.getElementById("database_name").value;
        
        //Если не заполнен Сервер БД
        if (db_host.length < 1)
        {
            alert("<?php echo lang('db_host_check') ?>");
            document.getElementById('server_db').value = "";
            return false;
        }
        //Если не заполнен пользователь БД
        if (db_user.length < 1)
        {
            alert("<?php echo lang('db_user_check') ?>");
            document.getElementById('login_db').value = "";
            return false;
        }
        //Если не заполнено имя БД
        if (db_name.length < 1)
        {
            alert("<?php echo lang('db_name_check') ?>");
            document.getElementById('database_name').value = "";
            return false;
        }
        //Если email не соответствует типу
        if (!value.match(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i)) {
            alert("<?php echo lang('email_check') ?>");
            document.getElementById('email').value = "";
            return false;
        } else
        if (confirm("<?php echo lang('confirm_install') ?>"))
            document.forms.submit();
        return false;
    }
</script>