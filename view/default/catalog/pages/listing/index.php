<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach ($VIEW->layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}

?>

<script type="text/javascript" language="javascript">
    $(window).load(function () {
        $(".item-heading").simpleEQH();
    });
</script>

<!-- Функция для установки Cookie -->
<script type="text/javascript">
    function setCookie(key, value, days) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (days * 1 * 24 * 60 * 60 * 1000));
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
        } if (getCookie('cookie_list') === 'grid'){
            $('#listing .item').removeClass('col-xs-12 list-group-item');
            $('#listing .item').addClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
        }
        
        $('#list').click(function (event) {
            event.preventDefault();
            $('#listing .item').removeClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
            $('#listing .item').addClass('col-xs-12 list-group-item');
            setCookie('cookie_list', 'list', 30);
        });
        $('#grid').click(function (event) {
            event.preventDefault();
            $('#listing .item').removeClass('col-xs-12 list-group-item');
            $('#listing .item').addClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
            setCookie('cookie_list', 'grid', 30);
        });
    });
</script>

<h3>Name Categories</h3>

<div class="contentText">
    <div class="well well-sm">
        <div class="btn-group">
            <a href="#" id="grid" class="btn btn-default"><span class="glyphicon glyphicon-th"></span></a>
            <a href="#" id="list" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span></a>
        </div>
    </div>
    <div id="listing" class="row">
        <?php foreach ($products as $value) { ?>
            <div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                <div class="productHolder">
                    <a href="/?route=products&id=<?php echo $value[0] ?>"><img src="/uploads/images/products/resize_1/<?php echo $value[2] ?>" class="img-responsive"></a>
                    <div class="caption">
                        <h5 class="item-heading"><a href="/?route=products&id=<?php echo $value[0] ?>"><?php echo $value[1] ?></a></h5>
                        <div class="item-text"> </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row button">
                        <div class="col-xs-6"><button type="button" class="btn btn-default"><?php echo $PRODUCTS->productPrice($value[3], $CURRENCIES, 1) ?></button></div>
                        <div class="col-xs-6 text-right"><a id="btn1" href="#" class="btn btn-primary"><span class="cart"></span> Buy Now</a></div>
                    </div>
                </div>
            </div>
        <?php } ?>  
    </div>
</div>