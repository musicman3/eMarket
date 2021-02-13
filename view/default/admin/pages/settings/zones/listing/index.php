<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Func,
    Messages,
    Pages,
    Settings,
    Valid
};
use \eMarket\Admin\ZonesListing;

require_once('modal/index.php')
?>

<div id="settings_zones_listing">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h5 class="card-title">
                <span class="settings_back"><a class="btn btn-primary btn-sm" href="<?php echo Settings::parentPartitionGenerator() ?>"><span class="bi-reply"></span></a></span><span class="settings_name"><?php echo Settings::titlePageGenerator() ?></span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="align-middle">
                            <th colspan="2"><?php echo Pages::counterPage() ?></th>

                            <th>
                                <div class="gap-2 d-flex justify-content-end">

                                    <a href="#index" class="btn btn-primary btn-sm" data-bs-toggle="modal"><span class="bi-pen"></span></a>

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                        <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                        <input hidden name="zone_id" value="<?php echo ZonesListing::$zones_id ?>">
                                        <?php if (Pages::$start > 0) { ?>
                                            <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-left-short"></span></button>
                                        <?php } else { ?>
                                            <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-left-short"></span></a>
                                        <?php } ?>
                                    </form>

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="start" value="<?php echo Pages::$start ?>">
                                        <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                        <input hidden name="zone_id" value="<?php echo ZonesListing::$zones_id ?>">
                                        <?php if (Pages::$finish != Pages::$count) { ?>
                                            <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-right-short"></span></button>
                                        <?php } else { ?>
                                            <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-right-short"></span></a>
                                        <?php } ?>
                                    </form>

                                </div>
                            </th>
                        </tr>
                        <?php if (Pages::$count > 0) { ?>
                            <tr class="align-middle">
                                <th> </th>
                                <th><?php echo lang('country') ?></th>
                                <th> </th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php
                        for (Pages::$start, ZonesListing::$count = 0; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {
                            ?>
                            <tr class="align-middle">
                                <td class="sortleft"><span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="right" title="<?php echo ZonesListing::$text_arr[ZonesListing::$count] ?>" class="btn btn-primary btn-sm bi-eye-fill"></span></td>
                                <td><?php echo Func::filterArrayToKey(ZonesListing::$countries_multiselect_temp, 0, Pages::$table['line'][0], 1)[0] ?></td>
                                <td> </td>
                            </tr>
                            <?php
                            ZonesListing::$count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>