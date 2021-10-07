<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Settings
};
use eMarket\Core\Modules\Tabs\Reviews;
?>
<div id="panel_reviews" class="tab-pane fade show">
    <div id="reviews_block" class="item-text border border-top-0 rounded-bottom p-2">

        <?php
        if (Authorize::$customer != FALSE) {

            if (Reviews::$author_check == FALSE && Reviews::purchaseCheck(Authorize::$customer['email']) == 'TRUE') {
                ?>

                <form class="was-validated">
                    <div class="mb-2"><?php echo lang('modules_tabs_reviews_catalog_your_rating') ?></div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="stars" id="stars_1" value="1" required>
                        <label class="form-check-label" for="stars_1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="stars" id="stars_2" value="2">
                        <label class="form-check-label" for="stars_2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="stars" id="stars_3" value="3">
                        <label class="form-check-label" for="stars_3">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="stars" id="stars_4" value="4">
                        <label class="form-check-label" for="stars_4">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="stars" id="stars_5" value="5">
                        <label class="form-check-label" for="stars_5">5</label>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control" placeholder="<?php echo lang('modules_tabs_reviews_catalog_write_review') ?>" name="review" id="review" rows="4" required></textarea>
                    </div>

                    <div class="mb-2"><button type="button" id="add_review" class="btn btn-primary" onclick="Reviews.addReview()"><?php echo lang('modules_tabs_reviews_catalog_publish') ?></button></div>

                </form>

                <?php
            } elseif (Reviews::$author_check == TRUE && Reviews::purchaseCheck(Authorize::$customer['email']) == 'TRUE' && Reviews::reviewStatus() == 0) {
                ?>
                <div class="card mt-2">
                    <div class="card-header container text-white bg-success">
                        <div class="row">
                            <div class="col-auto me-auto"><?php echo lang('modules_tabs_reviews_catalog_moderation') ?></div>
                        </div>
                    </div>
                </div>
            <?php } elseif (Reviews::$author_check == FALSE && Reviews::purchaseCheck(Authorize::$customer['email']) == 'FALSE') {
                ?>
                <div class="card mt-2">
                    <div class="card-header container text-white bg-success">
                        <div class="row">
                            <div class="col-auto me-auto"><?php echo lang('modules_tabs_reviews_catalog_cannot_post') ?></div>
                        </div>
                    </div>
                </div>
            <?php } else {
                ?>
                <div class="card mt-2">
                    <div class="card-header container text-white bg-success">
                        <div class="row">
                            <div class="col-auto me-auto"><?php echo lang('modules_tabs_reviews_catalog_thanks') ?></div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        if (Reviews::$reviews != FALSE) {
            ?>

            <div class="card mt-2">
                <div class="card-header container text-white bg-primary">
                    <div class="row">
                        <div class="col-auto me-auto"><?php echo lang('modules_tabs_reviews_catalog_average_rating') ?>
                            <?php
                            for ($average = 0; $average < 5; $average++) {

                                if ($average <= round(Reviews::averageRating(), 0, PHP_ROUND_HALF_DOWN) - 1) {
                                    ?>
                                    <span class="bi-star-fill"></span>
                                <?php } elseif (Reviews::averageRating() > $average && Reviews::averageRating() < $average + 1) { ?>
                                    <span class="bi-star-half"></span>
                                <?php } else { ?>
                                    <span class="bi-star"></span>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <div id="reviews_data">
                <?php foreach (Reviews::$reviews as $review) {
                    ?>

                    <div class="card mt-2">
                        <div class="card-header container">
                            <div class="row">
                                <div class="col-auto me-auto"><?php echo Settings::dateLocale($review['date_add']) ?>
                                    <?php
                                    for ($count = 0; $count < 5; $count++) {
                                        if ($count < $review['stars']) {
                                            ?>
                                            <span class="text-warning bi-star-fill"></span>
                                        <?php } else { ?>
                                            <span class="text-warning bi-star"></span>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-auto"><cite><?php echo Reviews::reviewAuthor($review['author'])['firstname'] . ' ' . mb_substr(Reviews::reviewAuthor($review['author'])['lastname'], 0, 1) . '.' ?></cite></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <cite><?php echo json_decode($review['reviews'], true)[0] ?></cite>
                            </div>
                        </div>
                    </div>

                <?php }
                ?>

            </div>

            <input type="hidden" id="lines_on_page" name="lines_on_page" value="<?php echo Settings::linesOnPage() ?>" />
            <input type="hidden" id="more_count" name="more_count" value="" />
            <?php
        }
        if (Reviews::$count_to_page == Settings::linesOnPage()) {
            ?>

            <div class="card mt-2" id="more_block">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <button id="button_more" class="btn btn-primary btn-sm bi-arrow-down" type="button" onclick="Reviews.more()"> <?php echo lang('modules_tabs_reviews_catalog_button_show_more') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>