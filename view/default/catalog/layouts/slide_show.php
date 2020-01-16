<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<?php if ($slide_show == true) { ?>
<div class="container-fluid">
    <div id="Carousel" class="carousel slide hidden-xs" data-interval="5000" data-pause="hover" data-ride="carousel" data-wrap="true">
        <ol class="carousel-indicators">
            <li data-target="#Carousel" data-slide-to="0" class="active"></li>
            <li data-target="#Carousel" data-slide-to="1" class=""></li>
        </ol>
        <div class="carousel-inner" role="listbox" >
            <div class="item active">
		<a href="#">
		    <img src="" class="center-block" >
		</a>
	    </div>
            <div class="item">
		<a href="#">
		    <img src="" class="center-block">
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
</div>
<?php } ?>