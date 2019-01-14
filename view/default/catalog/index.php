<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Для смартфонов -->
<nav class="navbar navbar-inverse navbar-no-corners navbar-no-margin" role="navigation">
    <div class="container-fluid">
	<div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse-core-nav">
		<span class="sr-only">Toggle Navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	    </button>
	</div>

	<div class="collapse navbar-collapse" id="bs-navbar-collapse-core-nav">
	    <ul class="nav navbar-nav navbar-left">
		<li><a href="#"><i class="glyphicon glyphicon-home"></i><span class="hidden-sm"> Home</span></a></li>
		<li><a href="#"><i class="glyphicon glyphicon-certificate"></i><span class="hidden-sm">  New Products</span></a></li>
		<li><a href="#"><i class="glyphicon glyphicon-fire"></i><span class="hidden-sm"> Special Offers</span></a></li>
		<li><a href="#"><i class="glyphicon glyphicon-comment"></i><span class="hidden-sm"> Reviews</span></a></li>
	    </ul>
	    <ul class="nav navbar-nav navbar-right">
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-credit-card"></i><span class="hidden-sm"> Currencies</span> <span class="caret"></span></a>
		    <ul class="dropdown-menu">
			<li><a href="#">U.S. Dollar</a></li>
			<li><a href="#">Euro</a></li>
		    </ul>
		</li>
	    <li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i><span class="hidden-sm"> My Account</span> <span class="caret"></span></a>
		    <ul class="dropdown-menu">
			<li><a href="#">Log In</a></li>
			<li><a href="#">Register</a></li>
			<li class="divider"></li>
			<li><a href="#">My Account</a></li>
			<li><a href="#">My Orders</a></li>
			<li><a href="#">My Address Book</a></li>
			<li><a href="#">My Password</a></li>
		    </ul>
	    </li>
		<li class="nav navbar-text"><i class="glyphicon glyphicon-shopping-cart"></i> 0 items</li>
	    </ul>
	</div>
    </div>
</nav>
<!-- Для смартфонов -->

<!-- Wrapper -->
<div id="bodyWrapper" class="container-fluid">

    <!-- Лого и поиск -->
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
    <!-- Лого и поиск -->
    
    <div class="clearfix"></div>

    <!-- Breadcrumb -->
    <ul class="breadcrumb">
	<li class="selected"><a href="#">Home</a></li>
        <li class="selected"><a href="#">Categories</a></li>
    </ul>
    <!-- Breadcrumb -->

    <!-- Слайдер -->
    <div id="Carousel" class="carousel slide hidden-xs hidden-sm" data-interval="5000" data-pause="hover" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#Carousel" data-slide-to="0" class="active"></li>
            <li data-target="#Carousel" data-slide-to="1"></li>
            <li data-target="#Carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox" >
            <div class="item active">
		<a href="#">
		    <img class="center-block" src="/uploads/images/slideshow/originals/slider-1.jpg" alt="">
		    <div class="carousel-caption">
		    <h3>Los Angeles</h3>
		    <p>LA is always so much fun!</p>
		    </div>
		</a>
	    </div>
            <div class="item">
		<a href="#">
		    <img class="center-block" src="/uploads/images/slideshow/originals/slider-2.jpg" alt="">
		    <div class="carousel-caption">
		    <h3>Chicago</h3>
		    <p>Thank you, Chicago!</p>
		    </div>
		</a>
	    </div>
            <div class="item">
		<a href="#">
		    <img class="center-block" src="/uploads/images/slideshow/originals/slider-3.jpg" alt="">
		    <div class="carousel-caption">
		    <h3>New York</h3>
		    <p>We love the Big Apple!</p>
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
    <!-- Слайдер -->

    <!-- Контент -->
    <div class="row">
        
        <!-- Центр -->
        <div id="bodyContent" class="col-md-8 col-md-push-2">
	    <h3>Welcome Bootstrap 3 Demo</h3>
	    <div class="contentContainer">
		<div class="contentText">
		    <h4>Welcome Guest!</h4>
		</div>
		<div class="contentText after">
		    The default shopping cart comes with Jquery UI, Grid960, Fancybox and BxGallery, in this demo those have been replaced by Boostrap and Bootstrap 3 Lightbox making it lighter, faster and responsive.
		</div>		

		<div class="clearfix"></div>

		<div class="contentText">
		    <h4>Welcome Guest!</h4>
		</div>
		<div class="contentText before">
		    The default shopping cart comes with Jquery UI, Grid960, Fancybox and BxGallery, in this demo those have been replaced by Boostrap and Bootstrap 3 Lightbox making it lighter, faster and responsive.
		</div>
	    </div>
        </div>
        <!-- Центр -->

        <!-- Левая-->
        <div id="columnLeft" class="col-lg-2 col-md-2 col-sm-6 col-xs-12 col-md-pull-8">
            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>
                <div class="panel-body">
                    <a href="#">Hardware-&gt;</a><br>
                    <a href="#">Software-&gt;</a><br>
                </div>
            </div>
        </div>
        <!-- Левая -->

        <!-- Правая -->
        <div id="columnRight" class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Shopping Cart</div>
                <div class="panel-body">
		    <p class="nav text-center"><i class="glyphicon glyphicon-shopping-cart"></i> 0 items</p>
                </div>
            </div>
        </div>
        <!-- Правая -->

    </div>
    <!-- Контент -->

</div>
<!-- Wrapper -->

<!-- Подвал -->
<div class="footer">
    <p align="center"><?php echo date('Y'); ?> | eMarket Design by Prizraki</p>
</div>
<!-- Подвал -->