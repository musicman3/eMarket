<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::layoutRouting('content') as $path) {
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

<h1><?php echo $categories_name ?></h1>

<?php if ($products == true) { ?>
    <div id="listing" class="contentText">
        <div class="well well-sm">
	    <div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Sort By <span class="caret"></span></button>
		<ul class="dropdown-menu text-right">
		    <li><a href="#">По названию</a></li>
		    <li><a href="#">По цене</a></li>
		</ul>
	    </div>
            <div class="btn-group pull-right">
                <a href="#" id="grid" class="btn btn-default item-grid active"><span class="glyphicon glyphicon-th"></span></a>
                <a href="#" id="list" class="btn btn-default item-list"><span class="glyphicon glyphicon-th-list"></span></a>
            </div>
        </div>

        <div class="row">
            <?php foreach ($products as $value) { ?>
                <div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
                    <div class="productHolder">
                        <a href="/?route=products&category_id=<?php echo \eMarket\Valid::inGET('category_id') ?>&parent_id=<?php echo \eMarket\Valid::inGET('parent_id') ?>&id=<?php echo $value['id'] ?>"><img src="/uploads/images/products/resize_1/<?php echo $value['logo_general'] ?>" alt="<?php echo $value['name'] ?>" class="img-responsive"></a>
                        <div class="caption">
                            <h5 class="item-heading"><a href="/?route=products&category_id=<?php echo \eMarket\Valid::inGET('category_id') ?>&parent_id=<?php echo \eMarket\Valid::inGET('parent_id') ?>&id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></h5>
                            <div class="item-text"> </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row button">
                            <div class="col-xs-6"><?php echo \eMarket\Ecb::priceInterface($value, 1) ?></div>
                            <div class="col-xs-6 text-right">
                                <form id="form_add_to_cart" name="form_add_to_cart" action="javascript:void(null);" onsubmit="addToCart(<?php echo $value['id'] ?>, 'true')">
                                    <button type="submit" class="btn btn-primary"><?php echo lang('buy_now') ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>  
        </div>

        <div class="well well-sm">
	    <div class="result-inner btn-group">Showing 1 to 8 of 10 (2 Pages)</div>
	    <div class="pagination-inner pull-right">
		<ul class="pagination">
		    <li class="active"><span>1</span></li>
		    <li><a href="#">2</a></li>
		</ul>
	    </div>
	</div>
    </div>
<?php } else { ?>
    <div id="listing" class="contentText">
        <div class="well well-sm">
            <div class="btn-group">
                <div class="btn"><?php echo lang('listing_no') ?></div>
            </div>
        </div>
    </div>
<?php
}

\eMarket\Ajax::сart('');

?>