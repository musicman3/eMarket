<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Ecb,
    Messages,
    Modules,
    Images,
    Pages,
    Settings,
    Valid
};
use eMarket\Admin\{
    Stock,
    Stickers
};

require_once('modal/index.php');
require_once('modal/index_product.php');
require_once('modal/attribute.php');
require_once('modal/values_attribute.php');
require_once('modal/add_group_attributes.php');
require_once('modal/add_attribute.php');
require_once('modal/add_values_attribute.php');
?>

<div id="stock">
    <div class="card">

        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
        </div>

        <div id="ajax_data" class='hidden' 
             data-session='<?php echo json_encode(Stock::$ses_verify) ?>'
             data-parentid='<?php echo json_encode(Stock::$parent_id) ?>'
             data-idsxrealparentid='<?php echo json_encode(Stock::$idsx_real_parent_id) ?>'
             data-sticker='<?php echo json_encode(Stickers::$stickers_flag) ?>'
             data-stickersdefault='<?php echo json_encode(Stickers::$stickers_default) ?>'
             data-stickers='<?php echo json_encode(Stickers::$stickers) ?>'
             data-langname='<?php echo json_encode(lang('#lang_all')[0]) ?>'
             data-attributescategory='<?php echo json_encode(Stock::$attributes_category) ?>'
             data-discounts='<?php echo json_encode(Modules::$discounts) ?>'
             data-discountdefault='<?php echo json_encode(Modules::$discount_default) ?>'
             data-resizemax='<?php echo json_encode(Images::imgResizeMax(Stock::$resize_param)) ?>'
             data-resizemaxprod='<?php echo json_encode(Images::imgResizeMax(Stock::$resize_param_product)) ?>'
             data-lang='<?php echo json_encode(lang()) ?>'
             data-jsondataproduct='<?php echo Stock::$json_data_product ?>'
             data-jsondatacategory='<?php echo Stock::$json_data_category ?>'>
        </div>
        <?php if (Stock::$count_lines_merge > 0) { ?>
            <div class="card-body">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 px-0">
                    <form>
                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                        <div class="input-group input-group-sm">
                            <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                            <button type="submit" class="btn btn-primary bi-search"></button>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="table-id" class="table table-hover mb-0">
                        <thead>
                            <tr class="align-middle">
                                <th colspan="5"><?php echo Pages::counterPageStock() ?></th>
                                <th>
                                    <div class="gap-2 d-flex justify-content-end">

                                        <form>
                                            <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                            <input hidden name="backstart" value="<?php echo Stock::$start ?>">
                                            <input hidden name="backfinish" value="<?php echo Stock::$finish ?>">
                                            <input hidden name="nav_parent_id" value="<?php echo Stock::$parent_id ?>">
                                            <button type="submit" class="btn btn-sm btn-primary bi-arrow-left-short <?php echo Stock::leftButton() ?>"></button>
                                        </form>

                                        <form>
                                            <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                            <input hidden name="start" value="<?php echo Stock::$start ?>">
                                            <input hidden name="finish" value="<?php echo Stock::$finish ?>">
                                            <input hidden name="nav_parent_id" value="<?php echo Stock::$parent_id ?>">
                                            <button type="submit" class="btn btn-sm btn-primary bi-arrow-right-short <?php echo Stock::rightButton() ?>"></button>
                                        </form>

                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="sort-list">

                            <?php
                            if (Stock::$parent_id > 0) {
                                ?>

                                <tr class="sortno align-middle unselectable">
                                    <td class="sortleft-m"></td>
                                    <td colspan="5">

                                        <form>
                                            <div>
                                                <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                <button name="parent_up" value="<?php echo Stock::$parent_id ?>" class="btn btn-outline-secondary btn bi-three-dots" title="" action="index.php" formmethod="get"></button>
                                            </div>
                                        </form>

                                    </td>
                                </tr>

                                <?php
                            }

                            for (Stock::$start; Stock::$start < Stock::$finish; Stock::$start++, Stock::$transfer++) {

                                if (Stock::$start < Stock::$count_lines_cat) {
                                    ?>

                                    <tr id="<?php echo Stock::categoriesText('transfer', 'context-one')[1] ?>" class="<?php echo Pages::sortiesClass('info') . ' ' . Stock::transferClass('unselectable') . ' ' . Stock::categoriesText('transfer', 'context-one')[0] ?>  sort-list align-middle" unitid="<?php echo Stock::$arr_merge['cat'][Stock::$start]['id'] ?>">

                                        <?php if (!Valid::inGET('search')) { ?>
                                            <td class="sortyes sortleft-m bi-arrows-move"></td>
                                        <?php } else { ?>
                                            <td class="sortleft-m"></td>
                                            <?php
                                        }

                                        if (Stock::statusCatButton('bi-folder2-open', 'bi-arrow-left-right') != false) {
                                            ?>    
                                            <td class="sortleft"><div><a href="#" class="btn <?php echo Stock::statusCatClass('btn-primary', 'btn-secondary') ?> btn disabled"><span class="<?php echo Stock::statusCatButton('bi-folder2-open', 'bi-arrow-left-right') ?>"> </span></a></div></td>
                                        <?php } else { ?>    
                                            <td class="sortleft">

                                                <form>
                                                    <div>
                                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                        <button name="parent_down" value="<?php echo Stock::$arr_merge['cat'][Stock::$start]['id'] ?>" class="btn <?php echo Stock::statusCatClass('btn-primary', 'btn-secondary') ?> btn bi-folder2-open" title="<?php echo Stock::$arr_merge['cat'][Stock::$start]['name'] ?>" action="index.php" formmethod="get"></button>
                                                    </div>
                                                </form>

                                            </td>
                                        <?php } ?>    

                                        <td><?php echo Stock::categoriesText('transfer', 'context-one')[2] ?></td>
                                        <td></td>
                                        <td></td>
                                        <td class="sortleft-m"></td>
                                    </tr>

                                    <?php
                                }

                                if (Stock::$start >= Stock::$count_lines_cat && Stock::$transfer < Settings::linesOnPage()) {
                                    ?>
                                    <tr id="products_<?php echo Stock::$arr_merge['prod'][Stock::$start . 'a']['id'] ?>" class="context-one align-middle">
                                        <td class="sortleft-m"></td>    
                                        <td class="sortleft text-center"><i class="<?php echo Stock::statusProdClass('text-success', 'text-danger', 'text-opacity-50') ?> bi-circle-fill"></i></td>
                                        <td><img class="rounded" src="/uploads/images/products/resize_0/<?php echo Stock::$arr_merge['prod'][Stock::$start . 'a']['logo_general'] ?>" onError="this.style.display='none'"></td>
                                        <td id="contextproduct_<?php echo Stock::$arr_merge['prod'][Stock::$start . 'a']['id'] ?>">
                                            <div class="float-start"><?php echo Stock::$arr_merge['prod'][Stock::$start . 'a']['name'] ?></div>
                                            <div class="float-end"><?php echo Ecb::priceInterface(Stock::$arr_merge['prod'][Stock::$start . 'a'], 1) ?></div>
                                        </td>
                                        <td class="sortleft-m"><?php echo Stock::discountLabel('<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="' . Stock::productSaleTooltip(Stock::$arr_merge['prod'][Stock::$start . 'a']['discount']) . '" class="' . Stock::statusProdClass('bi-tag-fill', 'bi-tag-fills') . ' text-primary"> </span>', '<span class="bi-tag-fill"></span>') ?></td>
                                        <td class="sortleft-m"><?php echo Stock::stickerData('<span class="badge bg-success">', '</span>') ?></td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

        <?php } else { ?>

            <div class="card-body">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 px-0">
                    <form>
                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                        <div class="input-group input-group-sm">
                            <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                            <button type="submit" class="btn btn-primary bi-search"></button>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="align-middle">
                                <th colspan="3"><?php echo lang('no_listing') ?></th>
                                <th>
                                    <div class="gap-2 d-flex justify-content-end">
                                        <a type="submit" class="btn btn-primary disabled bi-arrow-left-short"></a>
                                        <a type="submit" class="btn btn-primary disabled bi-arrow-right-short"></a>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="sort-list">
                            <tr class="sortno align-middle unselectable">
                                <td class="sortleft-m"></td>

                                <?php if (Stock::$parent_id > 0) { ?>

                                    <td class="sortleft">
                                        <form>
                                            <div>
                                                <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                <button name="parent_up" value="<?php echo Stock::$parent_id ?>" class="btn btn-outline-secondary bi-three-dots" title="" action="index.php" formmethod="get"></button>
                                            </div>
                                        </form>
                                    </td>

                                <?php } else { ?>

                                    <td class="sortleft-m"></td>

                                <?php } ?>

                                <td id="parent" class="context-one"><div><?php echo lang('no_listing') ?></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php } ?>

    </div>
</div>