<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h3><?php echo $products[1] ?></h3>

<div class="contentText">
    <div id="products" class="row list-group">
	<div class="list-group-item">
	    <img src="/uploads/images/products/resize_2/<?php echo $products[7] ?>" class="img-responsive list-group-image">
	    <?php echo $products[2] ?>
	    <div class="clearfix"></div>
	    <div class="row button">
		<div class="col-xs-6"><button type="button" class="btn btn-default"><?php echo $product_price ?></button></div>
		<div class="col-xs-6 text-right"><a id="btn1" href="#" class="btn btn-primary"><span class="cart"></span> Add to Cart</a></div>
	    </div>
	</div>
    </div>
</div>

<?php
// ПОДКЛЮЧАЕМ БОКС КОНТЕНТА
foreach ($VIEW->layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>