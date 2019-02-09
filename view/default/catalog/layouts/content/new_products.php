<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<script type="text/javascript" language="javascript">
$(window).load(function(){
$(".grid-item").simpleEQH();
$(".grid-item-heading").simpleEQH();
});
</script>

<div class="contentText">
    <h4>New Products</h4>
    <div id="products" class="row grid-group">
    <?php for ($x=0; $x<count($products_new); $x++){ ?>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
	    <div class="productHolder">
		<div class="grid-item"><a href="<?php echo $products_new[$x][0]; ?>"><img src="/uploads/images/products/resize_1/<?php echo $products_new[$x][7]; ?>" class="img-responsive img-rounded center-block"></a></div>
		<h5 class="text-center grid-item-heading"><a href="<?php echo $products_new[$x][0]; ?>"><?php echo $products_new[$x][1]; ?></a></h5>
		<div class="clearfix"></div>
		<div class="row button">
		    <div class="col-xs-6"><button type="button" class="btn btn-default"><?php echo $products_new[$x][12]; ?></button></div>
		    <div class="col-xs-6 text-right"><a id="btn1" href="<?php echo $products_new[$x][0]; ?>" class="btn btn-primary">Buy Now</a></div>
		</div>
	    </div>
	</div>
    <?php } ?>
    </div>
</div>