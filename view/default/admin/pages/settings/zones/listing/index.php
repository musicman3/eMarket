<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Добавить" -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<div id="settings_zones_listing">
    <div class="panel panel-default">
        <div class="panel-heading">
            <!--Выводим уведомление об успешном действии-->
            <div id="alert_block"><?php \eMarket\Core\Messages::alert(); ?></div>
            <h3 class="panel-title">
                <span class="settings_back"><a class="btn btn-primary btn-xs" href="<?php echo \eMarket\Core\Settings::parentPartitionGenerator() ?>"><span class="back glyphicon glyphicon-share-alt"></span></a></span><span class="settings_name"><?php echo \eMarket\Core\Settings::titlePageGenerator() ?></span>
            </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo \eMarket\Core\Pages::counterPage() ?></th>

                            <th>
                                <div class="flexbox">

                                    <div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a></div>

                                    <form>
                                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                                        <input hidden name="backstart" value="<?php echo \eMarket\Core\Pages::$start ?>">
                                        <input hidden name="backfinish" value="<?php echo \eMarket\Core\Pages::$finish ?>">
                                        <input hidden name="zone_id" value="<?php echo \eMarket\Admin\ZonesListing::$zones_id ?>">
                                        <div class="b-left">
                                            <?php if (\eMarket\Core\Pages::$start > 0) { ?>
                                                <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
                                            <?php } else { ?>
                                                <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                            <?php } ?>
                                        </div>
                                    </form>

                                    <form>
                                        <input hidden name="route" value="<?php echo \eMarket\Core\Valid::inGET('route') ?>">
                                        <input hidden name="start" value="<?php echo \eMarket\Core\Pages::$start ?>">
                                        <input hidden name="finish" value="<?php echo \eMarket\Core\Pages::$finish ?>">
                                        <input hidden name="zone_id" value="<?php echo \eMarket\Admin\ZonesListing::$zones_id ?>">
                                        <div>
                                            <?php if (\eMarket\Core\Pages::$finish != \eMarket\Core\Pages::$count) { ?>
                                                <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
                                            <?php } else { ?>
                                                <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                            <?php } ?>
                                        </div>
                                    </form>

                                </div>
                            </th>
                        </tr>
                        <?php if (\eMarket\Core\Pages::$count > 0) { ?>
                            <tr class="border">
                                <th> </th>
                                <th><?php echo lang('country') ?></th>
                                <th> </th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php
                        for (\eMarket\Core\Pages::$start, \eMarket\Admin\ZonesListing::$count = 0; \eMarket\Core\Pages::$start < \eMarket\Core\Pages::$finish; \eMarket\Core\Pages::$start++, \eMarket\Core\Pages::lineUpdate()) {
                            ?>
                            <tr>
                                <td class="sortleft"><span data-toggle="tooltip" data-html="true" data-placement="right" data-original-title="<?php echo \eMarket\Admin\ZonesListing::$text_arr[\eMarket\Admin\ZonesListing::$count] ?>" class="btn btn-primary btn-xs glyphicon glyphicon-eye-open"></span></td>
                                <td><?php echo \eMarket\Core\Func::filterArrayToKey(\eMarket\Admin\ZonesListing::$countries_multiselect_temp, 0, eMarket\Core\Pages::$table['line'][0], 1)[0] ?></td>
                                <td> </td>
                            </tr>
                            <?php
                            \eMarket\Admin\ZonesListing::$count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>