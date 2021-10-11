<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Admin\Slideshow;
use eMarket\Core\Settings;

Slideshow::view();

if (Slideshow::$slideshow == true) {
    ?>
    <div class="container-fluid mt-3 mb-3">
        <div id="Carousel" class="carousel slide carousel-fade d-none d-md-block" 
             data-bs-interval="<?php echo Slideshow::$slide_interval ?>" 
             data-bs-pause="<?php echo Slideshow::$slide_pause ?>" 
             data-bs-ride="<?php echo Slideshow::$autostart ?>" 
             data-bs-wrap="<?php echo Slideshow::$cicles ?>" 
             data-bs-touch="true" 
             data-bs-keyboard="true">
                 <?php if (Slideshow::$indicators == 'true') { ?>
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#Carousel" data-bs-slide-to="0" class="active"></button>
                    <?php for ($x = 1; $x < count(Slideshow::$slideshow_array); $x++) { ?>
                        <button type="button" data-bs-target="#Carousel" data-bs-slide-to="<?php echo $x ?>"></button>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="carousel-inner rounded">
                <?php
                foreach (Slideshow::$slideshow as $images_data) {
                    foreach (json_decode($images_data['logo'], true) as $logo) {
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
                <a class="carousel-control-prev bi-chevron-left" href="#Carousel" data-bs-slide="prev"></a>
                <a class="carousel-control-next bi-chevron-right" href="#Carousel" data-bs-slide="next"></a>
            <?php } ?>
        </div>
    </div>
    <?php
}