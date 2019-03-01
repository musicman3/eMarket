<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ БОКС КОНТЕНТА
foreach ($VIEW->layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}

?>

<h3>Name Categories</h3>

<div class="contentText">
    <div id="listing" class="row list-group">
        <?php foreach ($products as $value) { ?>
	<div class="list-group-item">
	    <div class="productHolder">
		<div class="col-xs-2">
		    <a href="/products/?id=<?php echo $value[0] ?>"><img src="/uploads/images/products/resize_1/<?php echo $value[2] ?>" class="img-responsive list-group-image"></a>
		</div>
		<div class="col-xs-10">
		    <h4 class="list-item-heading"><a href="/products/?id=<?php echo $value[0] ?>"><?php echo $value[1] ?></a></h4>
		    <div class="list-item-text"><?php echo $value[4] ?></div>
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