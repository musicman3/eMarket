<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div id="bodyWrapper" class="container-fluid">

    <div id="header">
        <div class="col-sm-4">
            <a href=""><img src="/view/<?php echo $SET->template() ?>/catalog/images/emarket.png"></a>
        </div>
        <div class="col-sm-8">
	    <div class="searchbox-margin">
		<form name="quick_find" action="#" method="get" class="form-horizontal">
		    <div class="input-group">
			<input type="search" name="keywords" required="" placeholder="Search" class="form-control">
			    <span class="input-group-btn">
				<button type="submit" class="btn btn-primary">
				    <i class="glyphicon glyphicon-search"></i>
				</button>
			    </span>
		     </div>
		</form>
	    </div>
	 </div>
    </div>
    
    <div class="clearfix"></div>

    <ul class="breadcrumb">
	<li class="selected"><a href="#">Home</a></li>
        <li>Categories</li>
    </ul>

    <div id="Carousel" class="carousel slide hidden-xs hidden-sm" data-interval="5000" data-pause="hover" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#Carousel" data-slide-to="0" class="active"></li>
        </ol>
        <div class="carousel-inner" role="listbox" >
            <div class="item active">
		<a href="#">
		    <img class="center-block" src="/uploads/images/slideshow/resize_0/slider-1.jpg" alt="">
		    <div class="carousel-caption">
		    <h3>Los Angeles</h3>
		    <p>LA is always so much fun!</p>
		    </div>
		</a>
	    </div>
        </div>
        <a class="carousel-control left" href="#Carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#Carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>

<script type="text/javascript" language="javascript">
$(window).load(function(){ 
$(".list-item").simpleEQH();
$(".list-group-item-heading").simpleEQH();
});
</script>

    <div class="row">
        
        <div id="bodyContent" class="col-md-10 col-md-push-2">
	    <h3>eMarket Bootstrap 3 Demo</h3>
	    <div class="contentContainer">
		<div class="contentText-before">
		    <h4>Welcome Guest!</h4>
		    <p>The default shopping cart comes with Jquery UI, Grid960, Fancybox and BxGallery, in this demo those have been replaced by Boostrap and Bootstrap 3 Lightbox making it lighter, faster and responsive.</p>
		</div>
		<div class="clearfix"></div>
		<div class="contentText-after">
		    <h4>New Products!</h4>
		    <div id="products" class="row list-group">

			<?php for ($x=0; $x<count($products_new); $x++){ ?>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item">
			    <div class="productHolder">
				<div class="list-item"><a href="<?php echo $products_new[$x][0]; ?>"><img src="/uploads/images/products/resize_1/<?php echo $products_new[$x][7]; ?>" class="img-responsive img-rounded center-block"></a></div>
				<div>
				    <h5 class="text-center list-group-item-heading"><a href="<?php echo $products_new[$x][0]; ?>"><?php echo $products_new[$x][1]; ?></a></h5>
				    <div class="clearfix"></div>
				    <div class="row button">
					<div class="col-xs-6">
					    <button type="button" class="btn btn-default btn-sm"><?php echo $products_new[$x][12]; ?></button>
					</div>
					<div class="col-xs-6 text-right">
					    <a id="btn1" href="<?php echo $products_new[$x][0]; ?>" class="btn btn-primary btn-sm">Buy Now</a>
					</div>
				    </div>
				</div>
			    </div>
			</div>
			<?php } ?>

		    </div>
		</div>
	    </div>
        </div>

        <div id="columnLeft" class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col-md-pull-10">
            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>
                <div class="panel-body">
		    <ul class="list-unstyled">
			<li><a href="#">Hardware</a></li>
			<li><a href="#">Software</a></li>
		    </ul>
                </div>
            </div>
        </div>

    </div>

</div>