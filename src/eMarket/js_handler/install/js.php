<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    function validate() {
        var confirm = document.querySelector("#password_admin_confirm");
        if (document.querySelector("#password_admin").value !== document.querySelector("#password_admin_confirm").value) {
            confirm.setCustomValidity("<?php echo lang('password_check') ?>");
        } else {
            confirm.setCustomValidity('');
        }
    }
    document.querySelector('#database_type').addEventListener('change', function (event) {
        if (document.querySelector('#database_type').options.selectedIndex === 0) {
            document.querySelector('#database_family').removeAttribute('disabled');
            document.querySelector('#database_port').removeAttribute('disabled');
            document.querySelector('#database_port').value = '3306';
            document.querySelector('#server_db').removeAttribute('disabled');
            document.querySelector('#login_db').removeAttribute('disabled');
            document.querySelector('#password_db').removeAttribute('disabled');
        }
        if (document.querySelector('#database_type').options.selectedIndex === 1) {
            document.querySelector('#database_family').setAttribute('disabled', 'disabled');
            document.querySelector('#database_port').removeAttribute('disabled');
            document.querySelector('#database_port').value = '5432';
            document.querySelector('#server_db').removeAttribute('disabled');
            document.querySelector('#login_db').removeAttribute('disabled');
            document.querySelector('#password_db').removeAttribute('disabled');
        }
        if (document.querySelector('#database_type').options.selectedIndex === 2) {
            document.querySelector('#database_family').setAttribute('disabled', 'disabled');
            document.querySelector('#database_port').setAttribute('disabled', 'disabled');
            document.querySelector('#server_db').setAttribute('disabled', 'disabled');
            document.querySelector('#login_db').setAttribute('disabled', 'disabled');
            document.querySelector('#password_db').setAttribute('disabled', 'disabled');
        }
    });
</script>