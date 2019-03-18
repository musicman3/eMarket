<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$AJAX->сart('');

?>
<script type="text/javascript">
    $('#input-firstname').keyup(function () {
        if ($('#input-firstname').val() !== '') {
            $('.firstname').removeClass('has-error');
            $('.firstname').addClass('has-success');

        } else {
            $('.firstname').removeClass('has-success');
            $('.firstname').addClass('has-error');
        }
    });

    $('#input-lastname').keyup(function () {
        if ($('#input-lastname').val() !== '') {
            $('.lastname').removeClass('has-error');
            $('.lastname').addClass('has-success');

        } else {
            $('.lastname').removeClass('has-success');
            $('.lastname').addClass('has-error');
        }
    });
    
    $('#input-email').keyup(function () {
        var email = $('#input-email').val();
        if (!email.match(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i)) {
            $('.email').removeClass('has-success');
            $('.email').addClass('has-error');
        } else {
            $('.email').removeClass('has-error');
            $('.email').addClass('has-success');
        }
    });    
</script>