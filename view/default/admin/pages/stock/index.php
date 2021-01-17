<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<?php
require_once('modal/index.php');
require_once('modal/index_product.php');
require_once('modal/confirm.php');
require_once('modal/attribute.php');
require_once('modal/add_group_attributes.php');
require_once('modal/add_attribute.php');
require_once('modal/values_attribute.php');
require_once('modal/add_values_attribute.php');
?>

<div id="stock">
    <div class="panel panel-default">

        <div class="panel-heading">

            <div id="alert_block"><?php \eMarket\Core\Messages::alert(); ?></div>

            <h3 class="panel-title">
                <?php echo \eMarket\Core\Settings::titlePageGenerator() ?>
            </h3>
        </div>
        <div id="ajax_data" class='hidden' 
             data-jsondataproduct='<?php echo \eMarket\Admin\Stock::$json_data_product ?>'
             data-jsondatacategory='<?php echo \eMarket\Admin\Stock::$json_data_category ?>'>
        </div>
        <?php if (\eMarket\Admin\Stock::$count_lines_merge > 0) { ?>
            <div class="panel-body">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 offset-0">
                    <form>
                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                        <div class="input-group">
                            <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="4"><?php echo \eMarket\Core\Pages::counterPageStock() ?></th>
                                <th>

                                    <div class="flexbox">
                                        <form>
                                            <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                                            <input hidden name="backstart" value="<?php echo \eMarket\Admin\Stock::$start ?>">
                                            <input hidden name="backfinish" value="<?php echo \eMarket\Admin\Stock::$finish ?>">
                                            <input hidden name="nav_parent_id" value="<?php echo \eMarket\Admin\Stock::$parent_id ?>">
                                            <div class="b-left">
                                                <?php if (\eMarket\Admin\Stock::$start > 0) { ?>
                                                    <button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
                                                <?php } else { ?>
                                                    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                                <?php } ?>
                                            </div>
                                        </form>

                                        <form>
                                            <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                                            <input hidden name="start" value="<?php echo \eMarket\Admin\Stock::$start ?>">
                                            <input hidden name="finish" value="<?php echo \eMarket\Admin\Stock::$finish ?>">
                                            <input hidden name="nav_parent_id" value="<?php echo \eMarket\Admin\Stock::$parent_id ?>">
                                            <div>
                                                <?php if (\eMarket\Core\Pages::counterStock() < \eMarket\Admin\Stock::$count_lines_merge) { ?>
                                                    <button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
                                                <?php } else { ?>
                                                    <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                                <?php } ?>
                                            </div>
                                        </form>
                                    </div>

                                </th>
                            </tr>
                        </thead>
                        <tbody id="sort-list">

                            <?php
                            if (\eMarket\Admin\Stock::$parent_id > 0) {
                                ?>

                                <tr class="sortno">
                                    <td  class="sortleft-m"></td>
                                    <td colspan="4">

                                        <form>
                                            <div>
                                                <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                                                <button name="parent_up" value="<?php echo \eMarket\Admin\Stock::$parent_id ?>" class="btn btn-default btn-xs" title="" action="index.php" formmethod="get"><span class="glyphicon glyphicon-option-horizontal"></span></button>
                                            </div>
                                        </form>

                                    </td>
                                </tr>

                                <?php
                            }

                            for (\eMarket\Admin\Stock::$start; \eMarket\Admin\Stock::$start < \eMarket\Admin\Stock::$finish; \eMarket\Admin\Stock::$start++, \eMarket\Admin\Stock::$transfer++) {

                                if (\eMarket\Admin\Stock::$start < \eMarket\Admin\Stock::$count_lines_cat) {
                                    ?>

                                    <tr class="<?php echo \eMarket\Core\Settings::sorties('info') ?> sort-list" unitid="<?php echo \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['id'] ?>">

                                        <?php
                                        if (isset($_SESSION['buffer']['cat']) == true && in_array(\eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['id'], $_SESSION['buffer']['cat']) == true && \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['status'] == 1) {
                                            echo \eMarket\Core\Settings::sorties();
                                            ?>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <?php
                                        } elseif (isset($_SESSION['buffer']['cat']) == true && in_array(\eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['id'], $_SESSION['buffer']['cat']) == true && \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['status'] == 0) {
                                            echo \eMarket\Core\Settings::sorties();
                                            ?>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-default btn-xs disabled"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <?php
                                        } elseif (\eMarket\Admin\Stock::$transfer == \eMarket\Core\Settings::linesOnPage() + 1) {
                                            echo \eMarket\Core\Settings::sorties();
                                            ?>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-transfer"> </span></a></div></td>

                                            <?php
                                        } elseif (\eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['status'] == 0) {
                                            echo \eMarket\Core\Settings::sorties();
                                            ?>    
                                            <td class="sortleft">

                                                <form>
                                                    <div>
                                                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                                                        <button name="parent_down" value="<?php echo \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['id'] ?>" class="btn btn-default btn-xs" title="<?php echo \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['name'] ?>" action="index.php" formmethod="get"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>

                                            <?php
                                        } else {
                                            echo \eMarket\Core\Settings::sorties()
                                            ?>    
                                            <td class="sortleft">

                                                <form>
                                                    <div>
                                                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                                                        <button name="parent_down" value="<?php echo \eMarket\Admin\Stock::$arr_merge['cat'][eMarket\Admin\Stock::$start]['id'] ?>" class="btn btn-primary btn-xs" title="<?php echo \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['name'] ?>" action="index.php" formmethod="get"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>
                                            <?php
                                        }
                                        ?>

                                        <td class="option" id="<?php echo \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['id'] ?>"><span class="inactive" style="display: none;"></span>
                                            <?php if (\eMarket\Admin\Stock::$transfer == \eMarket\Core\Settings::linesOnPage() + 1) { ?>
                                                <div class="transfer" id="<?php echo \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['id'] ?>"><?php echo lang('categories_transfer') ?></div>
                                            <?php } else { ?>
                                                <div class="context-one" id="<?php echo \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['id'] ?>"><?php echo \eMarket\Admin\Stock::$arr_merge['cat'][\eMarket\Admin\Stock::$start]['name'] ?></div>
                                            <?php } ?>
                                        </td>	
                                        <td class="sortleft-m"></td>
                                        <td class="sortleft-m"></td>
                                    </tr>

                                    <?php
                                }

                                if (\eMarket\Admin\Stock::$start >= \eMarket\Admin\Stock::$count_lines_cat && \eMarket\Admin\Stock::$transfer < \eMarket\Core\Settings::linesOnPage() + 1) {
                                    ?>
                                    <tr>

                                        <?php if (isset($_SESSION['buffer']['prod']) == true && in_array(\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['id'], $_SESSION['buffer']['prod']) == true && \eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['status'] == 1) { ?>
                                            <td class="sortleft-m"></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-success btn-xs disabled"><span class="glyphicon glyphicon-shopping-cart"> </span></a></div></td>

                                        <?php } elseif (isset($_SESSION['buffer']['prod']) == true && in_array(\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['id'], $_SESSION['buffer']['prod']) == true && \eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['status'] == 0) { ?>
                                            <td class="sortleft-m"></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-default btn-xs disabled"><span class="glyphicon glyphicon-shopping-cart"> </span></a></div></td>

                                        <?php } elseif (\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['status'] == 0) { ?>
                                            <td class="sortleft-m"></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-shopping-cart"> </span></a></div></td>
                                        <?php } else { ?>

                                            <td class="sortleft-m"></td>
                                            <td class="sortleft"><div><a href="#" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-shopping-cart"> </span></a></div></td>

                                        <?php } ?>
                                        <td class="context-one option" id="product_<?php echo \eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['id'] ?>"><span class="inactive" style="display: none;"></span>
                                            <div class="pull-left"><?php echo \eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['name'] ?></div>
                                            <div class="pull-right"><?php echo \eMarket\Core\Ecb::priceInterface(\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a'], 1) ?></div>
                                        </td>

                                        <?php if (json_decode(\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['discount'], 1) > 0 && \eMarket\Core\Modules\Discount\Sale::status() == 1) { ?>
                                            <td class="sortleft"><span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="<?php echo \eMarket\Core\Settings::productSaleTooltip(\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['discount']) ?>" class="glyphicon glyphicon-tag text-primary"> </span></td>
                                        <?php } elseif (json_decode(\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['discount'], 1) == 0 && \eMarket\Core\Modules\Discount\Sale::status() == 1) { ?>
                                            <td class="sortleft"><span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="<?php echo \eMarket\Core\Settings::productSaleTooltip(\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['discount']) ?>" class="glyphicon glyphicon-tags text-primary"> </span></td>
                                        <?php } else { ?>
                                            <td class="sortleft-m"><span class="glyphicon glyphicon-tag"></span></td>
                                        <?php } ?>

                                        <?php if (\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['stiker'] != '' && \eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['stiker'] != NULL) { ?>
                                            <td class="sortleft"><span class="label label-success"><?php echo \eMarket\Admin\Stikers::$stiker_name[\eMarket\Admin\Stock::$arr_merge['prod'][\eMarket\Admin\Stock::$start . 'a']['stiker']] ?></span></td>
                                        <?php } else { ?>
                                            <td class="sortleft-m"></td>
                                        <?php } ?>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <?php
        } elseif (\eMarket\Admin\Stock::$count_lines_cat > 0 && \eMarket\Admin\Stock::$parent_id > 0) {
            ?>

            <div class="panel-body">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 offset-0">
                    <form>
                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                        <div class="input-group">
                            <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <div><?php echo lang('no_listing') ?></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="sortno">
                                <td class="sortleft-m"></td>
                                <td class="sortleft">

                                    <form>
                                        <div>
                                            <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                                            <button name="parent_up" value="<?php echo \eMarket\Admin\Stock::$parent_id ?>" class="btn btn-default btn-xs" title="" action="index.php" formmethod="get"><span class="glyphicon glyphicon-option-horizontal"></span></button>
                                        </div>
                                    </form>

                                </td>
                                <td class="options"><div class="context-one"><?php echo lang('no_listing') ?></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="panel-body">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 offset-0">
                    <form>
                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                        <div class="input-group">
                            <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <div><?php echo lang('no_listing') ?></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sortleft-m"></td>
                                <td class="sortleft-m"></td>
                                <td class="options"><div class="context-one"><?php echo lang('no_listing') ?></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>