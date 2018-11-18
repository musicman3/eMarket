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
	    <ul class="nav navbar-nav">
		<li><a class="store-brand" href="#"><i class="glyphicon glyphicon-home"></i><span class="hidden-sm"> Home</span></a></li>
		<li><a href="#"><i class="glyphicon glyphicon-certificate"></i><span class="hidden-sm">  New Products</span></a></li>
		<li><a href="#"><i class="glyphicon glyphicon-fire"></i><span class="hidden-sm"> Special Offers</span></a></li>
		<li><a href="#"><i class="glyphicon glyphicon-comment"></i><span class="hidden-sm"> Reviews</span></a></li>
	    </ul>
	    <ul class="nav navbar-nav navbar-right">
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-cog"></i><span class="hidden-sm"> Site Settings</span> <span class="caret"></span></a>
		    <ul class="dropdown-menu">
			<li><a href="#">U.S. Dollar</a></li>
			<li><a href="#">Euro</a></li>
		    </ul>
		</li>
	    <li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i><span class="hidden-sm"> My Account</span> <span class="caret"></span></a>
		    <ul class="dropdown-menu">
			<li><a href="#"><i class="glyphicon glyphicon-log-in"></i> Log In</a></li>
			<li><a href="#"><i class="glyphicon glyphicon-pencil"></i> Register</a></li>
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

<!-- Конец для смартфонов -->

<div id="bodyWrapper" class="container-fluid">

    <!--Лого и кнопки-->
    <div id="header">
        <div class="col-sm-4">
            <a href=""><img src="/view/<?php echo $TEMPLATE ?>/catalog/images/emarket.png"></a>
        </div>
        <div class="col-sm-8">
	    <div class="searchbox-margin">
		<form name="quick_find" action="#" method="get" class="form-horizontal">
		    <div class="input-group">
			<input type="search" name="keywords" required="" placeholder="Search" class="form-control">
			    <span class="input-group-btn">
				<button type="submit" class="btn btn-info">
				    <i class="glyphicon glyphicon-search"></i>
				</button>
			    </span>
		     </div>
		</form>
	    </div>
	 </div>
    </div>
    <!--Конец лого и кнопок-->

    <!--<div class="row"> </div>-->

    <!-- Breadcrumb -->
    <div>&nbsp;&nbsp;
        <ul class="breadcrumb">
            <li class="selected"><a href="#">Начало</a></li>
            <li class="selected"><a href="#">Категории</a></li>
        </ul>
    </div>
    <!-- Конец breadcrumb -->

    <!-- Начало слайдер -->

    <style type="text/css">
        .carousel {overflow: hidden;background: none;height: 210px !important;margin-bottom: 10px;}
        .carousel-inner {overflow: visible;}
        .carousel-inner img {left: 50%;max-width: none !important;min-width: 100%;min-height: 210px;top: 105px;position: absolute;transform: translate(-50%,-50%);}
    </style>

    <div id="Carousel" class="carousel slide hidden-xs hidden-sm" data-interval="5000" data-pause="hover" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#Carousel" data-slide-to="0" class="active"></li>
            <li data-target="#Carousel" data-slide-to="1"></li>
            <li data-target="#Carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active"><a href="#"><img class="img-responsive" src="/images/slideshow/dell.png" alt=""></a></div>
            <div class="item"><a href="#"><img class="img-responsive" src="/images/slideshow/apple.png" alt=""></a></div>
            <div class="item"><a href="#"><img class="img-responsive" src="/images/slideshow/hp.png" alt=""></a></div>
        </div>
        <a class="carousel-control left" href="#Carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#Carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>

    <!-- Конец слайдер -->

    <!-- Начало Контент -->

    <div class="row">

        <div id="bodyContent" class="col-md-8 col-md-push-2">

            <!-- Начало центр -->

            <img src="" height="30px;" id="pageIcon">

            <h1>Welcome Bootstrap 3 Demo</h1>

            <div class="contentContainer">
                <div class="contentText">
                    <h6>Welcome Guest!</h6>
                </div>

                <div class="contentText after">
                    <br><strong>Demonstration of Twitter Bootstrap 3 Framework.</strong><br><br>The default shopping cart comes with Jquery UI, Grid960, Fancybox and BxGallery, in this demo those have been replaced by Boostrap and Bootstrap 3 Lightbox making it lighter, faster and responsive.<br><br>This demo is based of the with default demo content, but with higher resolution product images and an automatic thumbnail generator added.<br><br><strong>NOTE:</strong> This demo is a plain "boilerplate" version without extra styling.
                </div>		

                <div class="clearfix"></div>

                <div class="contentText before">
                    <br><strong>Demonstration of Twitter Bootstrap 3 Framework.</strong><br><br>The default shopping cart comes with Jquery UI, Grid960, Fancybox and BxGallery, in this demo those have been replaced by Boostrap and Bootstrap 3 Lightbox making it lighter, faster and responsive.<br><br>This demo is based of the with default demo content, but with higher resolution product images and an automatic thumbnail generator added.<br><br><strong>NOTE:</strong> This demo is a plain "boilerplate" version without extra styling.
                </div>

            </div>
            <!-- Конец центр -->
        </div> 
        <!-- Начало левая-->
        <div id="columnLeft" class="col-lg-2 col-md-2 col-sm-6 col-xs-12 col-md-pull-8">

            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>
                <div class="panel-body">
                    <a href="#">Hardware-&gt;</a><br>
                    <a href="#">Software-&gt;</a><br>
                    <a href="#">DVD Movies-&gt;</a><br>
                    <a href="#">Gadgets</a><br>
                </div>
            </div>
        </div>
        <!--  Конец левая -->

        <!-- Начало правая -->
        <div id="columnRight" class="col-lg-2 col-md-2 col-sm-6 col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>
                <div class="panel-body">
                    <a href="#">Hardware-&gt;</a><br>
                    <a href="#">Software-&gt;</a><br>
                    <a href="#">DVD Movies-&gt;</a><br>
                    <a href="#">Gadgets</a><br>
                </div>
            </div>
        </div>

        <!-- Конец правая -->

    </div>

    <!-- Конец контент -->
</div>

<!-- Начало футер -->

<div class="footer">
    <p align="center"><?php echo date('Y'); ?> | eMarket Design by Prizraki</p>
</div>

<!-- Конец футер -->