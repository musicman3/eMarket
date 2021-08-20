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
</script>