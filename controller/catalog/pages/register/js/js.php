<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$AJAX->сart('');

?>
<script type="text/javascript">
    if ($('#input-firstname').val() !== '') {
        $('.firstname').removeClass('has-error');
        $('.firstname').addClass('has-success');
    }
    if ($('#input-lastname').val() !== '') {
        $('.lastname').removeClass('has-error');
        $('.lastname').addClass('has-success');
    }

    if ($('#input-email').val().match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
        $('.email').removeClass('has-error');
        $('.email').addClass('has-success');
    }

    $('#input-firstname').on('input', function () {
        if ($('#input-firstname').val() !== '') {
            $('.firstname').removeClass('has-error');
            $('.firstname').addClass('has-success');
        } else {
            $('.firstname').removeClass('has-success');
            $('.firstname').addClass('has-error');
        }
    });

    $('#input-lastname').on('input', function () {
        if ($('#input-lastname').val() !== '') {
            $('.lastname').removeClass('has-error');
            $('.lastname').addClass('has-success');
        } else {
            $('.lastname').removeClass('has-success');
            $('.lastname').addClass('has-error');
        }
    });

    $('#input-email').on('input', function () {
        var email = $('#input-email').val();
        if (!email.match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            $('.email').removeClass('has-success');
            $('.email').addClass('has-error');
        } else {
            $('.email').removeClass('has-error');
            $('.email').addClass('has-success');
        }
    });

    $('#input-confirm').on('input', function () {
        var password = $('#input-password').val();
        var confirm = $('#input-confirm').val();
        if (confirm === password && password.length > 6 && confirm.length > 6 && password.length < 41 && confirm.length < 41) {
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

    function validate() {
        var confirm = $('#input-confirm').get(0);
        var email = $('#input-email').get(0);
        if ($('#input-password').val() !== $('#input-confirm').val()) {
            confirm.setCustomValidity("<?php echo lang('password_check') ?>");
        } else {
            confirm.setCustomValidity('');
        }
        //Если email не соответствует типу
        if (!$('#input-email').val().match(/^[a-zA-Zа-яА-Я_\d][-a-zA-Zа-яА-Я0-9_\.\d]*\@[a-zA-Zа-яА-Я\d][-a-zA-Zа-яА-Я\.\d]*\.[a-zA-Zа-яА-Я]{2,4}$/)) {
            email.setCustomValidity("<?php echo lang('email_check') ?>");
        } else {
            email.setCustomValidity('');
        }
    }
</script>