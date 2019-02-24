<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//$DEBUG->trace($PRODUCTS->productData($VALID->inGET('id'))[0][7]);
?>

<h3><?php echo $product_category ?></h3>

<div class="contentText">
    <div id="products" class="row list-group">
	<div class="item col-sm-4 list-group-item">
	    <div class="productHolder">
		<img src="/uploads/images/products/resize_2/<?php echo $products[7] ?>" class="img-responsive">
		<h4 class="group inner list-item-heading"><?php echo $products[1] ?></h4>
		<p class="group inner list-item-text"><?php echo $products[2] ?></p>
		<div class="clearfix"></div>
		<div class="row button">
		    <div class="col-xs-6"><button type="button" class="btn btn-default"><?php echo $product_price ?></button></div>
		    <div class="col-xs-6 text-right"><a id="btn1" href="#" class="btn btn-primary"><span class="cart"></span> Add to Cart</a></div>
		</div>
	    </div>
	</div>
    </div>
</div>