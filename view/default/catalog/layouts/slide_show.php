<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<?php if (count($slideshow) > 0) { ?>
    <div class="container-fluid">
        <div id="Carousel" class="carousel slide hidden-xs" data-interval="<?php echo $slide_interval ?>" data-pause="<?php echo $slide_pause ?>" data-ride="<?php echo $autostart ?>" data-wrap="<?php echo $cicles ?>">
            <?php if ($indicators == 'true') { ?>
                <ol class="carousel-indicators">
                    <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                    <?php for ($x = 1; $x < count($slideshow_array); $x++) { ?>
                        <li data-target="#Carousel" data-slide-to="<?php echo $x ?>"></li>
                    <?php } ?>
                </ol>
            <?php } ?>
            <div class="carousel-inner">
                <?php
                foreach ($slideshow as $images_data) {
                    foreach (json_decode($images_data['logo'], 1) as $logo) {
                        if ($images_data['status'] == 1) {
                            ?>
                            <div class="item<?php echo $active_class ?>">
                                <a href="<?php echo $images_data['url'] ?>">
                                    <img src="/uploads/images/slideshow/resize_4/<?php echo $logo ?>" class="center-block" >
                                </a>
                                <div class="carousel-caption">
                                    <h3><?php echo $images_data['name'] ?></h3>
                                    <p><?php echo $images_data['heading'] ?></p>
                                </div>
                            </div>

                            <?php
                            $active_class = '';
                        }
                    }
                }
                ?>
            </div>
            <?php if ($navigation_key == 'true') { ?>
                <a class="carousel-control left" href="#Carousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="carousel-control right" href="#Carousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>