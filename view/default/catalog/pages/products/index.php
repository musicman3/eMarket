<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h3><?php echo $products[1] ?></h3>

<div class="contentText">
    <div id="products" class="row">
	<div class="item col-xs-12 list-group-item">
	    <img src="/uploads/images/products/resize_2/<?php echo $products[7] ?>" class="img-responsive">
	    <div class="caption">
		<div class="item-text"></div>
		<div class="clearfix"></div>
		<div class="row button">
		    <div class="col-xs-6"><button type="button" class="btn btn-default"><?php echo $product_price ?></button></div>
		    <div class="col-xs-6 text-right"><a id="btn1" href="#" class="btn btn-primary"><span class="cart"></span> Add to Cart</a></div>
		</div>
	    </div>
	    <br>
	    <div class="products_tab">
		<ul class="nav nav-tabs">
		    <li class="active"><a data-toggle="tab" href="#panel_add_1">Описание</a></li>
		</ul>
		<div class="tab-content">
		    <div id="panel_add_1" class="tab-pane fade in active">
			<div class="item-text"><?php echo $products[2] ?></div>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</div>

<?php
// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach ($VIEW->layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>