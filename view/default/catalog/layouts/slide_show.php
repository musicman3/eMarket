<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Admin\Slideshow;
use \eMarket\Core\Settings;

Slideshow::view();

if (Slideshow::$slideshow == true) {
    ?>
    <div class="container-fluid">
        <div id="Carousel" class="carousel slide d-none d-md-block" 
             data-bs-interval="<?php echo Slideshow::$slide_interval ?>" 
             data-bs-pause="<?php echo Slideshow::$slide_pause ?>" 
             data-bs-ride="<?php echo Slideshow::$autostart ?>" 
             data-bs-wrap="<?php echo Slideshow::$cicles ?>" 
             data-bs-slide="true"
             data-bs-touch="true" 
             data-bs-keyboard="true">
                 <?php if (Slideshow::$indicators == 'true') { ?>
                <ol class="carousel-indicators">
                    <li data-bs-target="#Carousel" data-bs-slide-to="0" class="active"></li>
                    <?php for ($x = 1; $x < count(Slideshow::$slideshow_array); $x++) { ?>
                        <li data-bs-target="#Carousel" data-bs-slide-to="<?php echo $x ?>"></li>
                    <?php } ?>
                </ol>
            <?php } ?>
            <div class="carousel-inner">
                <?php
                foreach (Slideshow::$slideshow as $images_data) {
                    foreach (json_decode($images_data['logo'], 1) as $logo) {
                        if ($images_data['status'] == 1 && strtotime($images_data['date_start']) <= Slideshow::$this_time && strtotime($images_data['date_finish']) >= Slideshow::$this_time) {
                            ?>
                            <div class="carousel-item <?php echo Settings::activeTab(0, 0) ?>">
                                <a href="<?php echo $images_data['url'] ?>">
                                    <img src="/uploads/images/slideshow/resize_4/<?php echo $logo ?>" class="d-block w-100" >
                                    <?php if ($images_data['animation'] == 1) { ?>
                                        <div class="carousel-caption slide-text-anime" style="color: <?php echo $images_data['color'] ?>;">
                                            <h3><?php echo $images_data['name'] ?></h3>
                                            <p><?php echo $images_data['heading'] ?></p>
                                        </div>
                                    <?php } else { ?>
                                        <div class="carousel-caption" style="color: <?php echo $images_data['color'] ?>;">
                                            <h3><?php echo $images_data['name'] ?></h3>
                                            <p><?php echo $images_data['heading'] ?></p>
                                        </div>
                                    <?php } ?>
				</a>
                            </div>

                            <?php
                        }
                    }
                }
                ?>
            </div>
            <?php if (Slideshow::$navigation_key == 'true') { ?>
                <a class="carousel-control-prev" href="#Carousel" data-bs-slide="prev">
                    <span class="bi-chevron-left"></span>
                </a>
                <a class="carousel-control-next" href="#Carousel" data-bs-slide="next">
                    <span class="bi-chevron-right"></span>
                </a>
            <?php } ?>
        </div>
    </div>
    <?php
}