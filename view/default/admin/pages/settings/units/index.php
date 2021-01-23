<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Messages,
    Pages,
    Settings,
    Valid
};
use \eMarket\Admin\Units;

require_once('modal/index.php')
?>

<div id="settings_units">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h3 class="panel-title">
                <span class="settings_back"><button type="button" onClick='location.href = "<?php echo Settings::parentPartitionGenerator() ?>"' class="btn btn-primary btn-sm"><span class="bi-reply"></span></button></span><span class="settings_name"><?php echo Settings::titlePageGenerator() ?></span>
            </h3>
        </div>
        <div class="modal-body">
            <div id="ajax_data" class='hidden' data-jsondata='<?php echo Units::$json_data ?>'></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="3"><?php echo Pages::counterPage() ?></th>

                            <th>
                                <div class="flexbox">

                                    <div class="b-left"><a href="#index" class="btn btn-primary btn-sm" data-bs-toggle="modal"><span class="bi-plus"></span></a></div>

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                        <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                        <div class="b-left">
                                            <?php if (Pages::$start > 0) { ?>
                                                <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-left-short"></span></button>
                                            <?php } else { ?>
                                                <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-left-short"></span></a>
                                            <?php } ?>
                                        </div>
                                    </form>

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="start" value="<?php echo Pages::$start ?>">
                                        <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                        <div>
                                            <?php if (Pages::$finish != Pages::$count) { ?>
                                                <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-right-short"></span></button>
                                            <?php } else { ?>
                                                <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-right-short"></span></a>
                                            <?php } ?>
                                        </div>
                                    </form>

                                </div>
                            </th>
                        </tr>
                        <?php if (Pages::$count > 0) { ?>
                            <tr class="border">
                                <th><?php echo lang('name_full') ?></th>
                                <th class="text-center"><?php echo lang('name_little') ?></th>
                                <th class="text-center"><?php echo lang('default') ?></th>
                                <th></th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                            <tr>
                                <td><?php echo Pages::$table['line']['name'] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line']['unit'] ?></td>
                                <?php if (Pages::$table['line']['default_unit'] == 1) { ?>
                                    <td class="text-center"><?php echo lang('confirm-yes') ?></td>
                                <?php } else { ?>
                                    <td class="text-center"><?php echo lang('confirm-no') ?></td>
                                <?php } ?>
                                <td>
                                    <div class="flexbox">
                                        <div class="b-left">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"><span class="bi-pencil-square"></span></button>
                                        </div>
                                        <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
                                            <input hidden name="delete" value="<?php echo Pages::$table['line']['id'] ?>">
                                            <div>
                                                <button type="submit" name="delete_but" class="btn btn-primary btn-sm" data-placement="left" data-bs-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="bi-trash"> </span></button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>