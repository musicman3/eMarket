<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

\eMarket\Ajax::сart('');
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#show_in_stock').bootstrapSwitch();
    if (document.getElementById('show_in_stock').checked) {
        $("#sort_0").attr("href", "<?php echo $sort_url ?>&sort=id&change=on");
        $("#sort_1").attr("href", "<?php echo $sort_url ?>&sort=name&change=on");
        $("#sort_2").attr("href", "<?php echo $sort_url ?>&sort=min&change=on");
        $("#sort_3").attr("href", "<?php echo $sort_url ?>&sort=max&change=on");
    } else {
        $("#sort_0").attr("href", "<?php echo $sort_url ?>&sort=id&change=off");
        $("#sort_1").attr("href", "<?php echo $sort_url ?>&sort=name&change=off");
        $("#sort_2").attr("href", "<?php echo $sort_url ?>&sort=min&change=off");
        $("#sort_3").attr("href", "<?php echo $sort_url ?>&sort=max&change=off");
    }
    $('#show_in_stock').on('switchChange.bootstrapSwitch', function (event, state) {
    if (document.getElementById('show_in_stock').checked) {
        document.location.href = '<?php echo \eMarket\Func::deleteGet('change') ?>&change=on';
    } else {
        document.location.href = '<?php echo \eMarket\Func::deleteGet('change') ?>&change=off';
    }
    });
</script>

<script type="text/javascript" language="javascript">
    $(window).load(function () {
        $(".item-heading").simpleEQH();
    });
</script>

<!-- Функция для установки Cookie -->
<script type="text/javascript">
    function setCookie(key, value, days) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }
</script>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {

        if (getCookie('cookie_list') === 'list') {
            $('#listing .item').removeClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
            $('#listing .item').addClass('col-xs-12 list-group-item');
        }
        if (getCookie('cookie_list') === 'grid') {
            $('#listing .item').removeClass('col-xs-12 list-group-item');
            $('#listing .item').addClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
        }
        if (getCookie('cookie_list') === 'list') {
            $('#listing .item-grid').removeClass('active');
            $('#listing .item-list').addClass('active');
        }
        if (getCookie('cookie_list') === 'grid') {
            $('#listing .item-list').removeClass('active');
            $('#listing .item-grid').addClass('active');
        }

        $('#list').click(function (event) {
            event.preventDefault();
            $('#listing .item').removeClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
            $('#listing .item').addClass('col-xs-12 list-group-item');
            $('#listing .item-grid').removeClass('active');
            $('#listing .item-list').addClass('active');
            setCookie('cookie_list', 'list', 30);
        });
        $('#grid').click(function (event) {
            event.preventDefault();
            $('#listing .item').removeClass('col-xs-12 list-group-item');
            $('#listing .item').addClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
            $('#listing .item-list').removeClass('active');
            $('#listing .item-grid').addClass('active');
            setCookie('cookie_list', 'grid', 30);
        });
    });
</script>
