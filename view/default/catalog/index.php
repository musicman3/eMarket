<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

</head>
<body>
    <!-- Для смартфонов -->

    <!--<nav class="navbar-inverse" role="navigation">
    <div class="row"> </div>

            <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
            </div>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<a href="#">Корзина</a>
    <div class="navbar-right col-md-3">
          
    </div>

</div>
    </nav>-->

    <!-- Конец для смартфонов -->

    <div id="bodyWrapper" class="container">

        <!--Лого и кнопки-->
        <div id="header">
            <div class="col-md-4">
                <a href=""><img src="/view/default/catalog/images/logo.jpg"></a>
            </div>
            <div class="col-md-8 text-right headerlinks"><div class="btn-group">

                    <a id="btn1" href="#" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-shopping-cart"></span> Корзина</a>
                    <a id="btn2" href="#" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-play"></span> Оплата</a>
                    <a id="btn3" href="#" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-user"></span> Аккаунт</a>

                </div>
            </div>
        </div>
        <!--Конец лого и кнопок-->

        <div class="row"> </div>

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
        <p align="center"><?php echo date('Y'); ?> | eCommerce Design by Prizraki</p>
    </div>

    <!-- Конец футер -->
