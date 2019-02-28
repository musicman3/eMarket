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
	<div class="list-group-item">
	    <div class="productHolder">
		<a href="#"><img src="images.jpg" alt="" title="" class="img-responsive list-group-image"></a>
		<h4 class="list-item-heading"><a href="#">Name</a></h4>
		<p class="list-item-text">Text…</p>
		<div class="clearfix"></div>
		<div class="row button">
		    <div class="col-xs-6"><button type="button" class="btn btn-default">Price</button></div>
		    <div class="col-xs-6 text-right"><a id="btn1" href="#" class="btn btn-primary"><span class="cart"></span> Buy Now</a></div>
		</div>
	    </div>
	</div>
    </div>
</div>