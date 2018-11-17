<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

error_reporting(-1);

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