<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Messages,
    Pages,
    Valid,
    Settings
};
?>

<div id="customers">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h3 class="panel-title">
                <?php echo Settings::titlePageGenerator() ?>
            </h3>
        </div>
        <div class="modal-body">

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 offset-0">
                <form>
                    <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                    <div class="input-group">
                        <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">
                                <span class="bi-search"></span>
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
                            <th colspan="4"><?php echo Pages::counterPage() ?></th>

                            <th>
                                <div class="flexbox">
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
                        <?php if (Pages::$finish > 0) { ?>
                            <tr class="border">
                                <th><?php echo lang('customers_firstname') ?></th>
                                <th class="text-center"><?php echo lang('customers_lastname') ?></th>
                                <th class="text-center"><?php echo lang('customers_date_created') ?></th>
                                <th class="text-center"><?php echo lang('customers_email') ?></th>
                                <th></th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                            <tr class="<?php echo Settings::statusSwitchClass(Pages::$table['line'][18]) ?>">
                                <td><?php echo Pages::$table['line'][3] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line'][4] ?></td>
                                <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line'][6]) ?></td>
                                <td class="text-center"><?php echo Pages::$table['line'][11] ?></td>
                                <td>
                                    <div class="flexbox">
                                        <form id="form_status<?php echo Pages::$table['line'][0] ?>" name="form_status" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_status<?php echo Pages::$table['line'][0] ?>')" enctype="multipart/form-data">
                                            <input hidden name="status" value="<?php echo Pages::$table['line'][0] ?>">
                                            <div class="b-left">
                                                <button type="submit" name="status_but" class="btn btn-primary btn-sm" data-bs-placement="left" data-bs-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-status') ?>"><span class="bi-power"> </span></button>
                                            </div>
                                        </form>
                                        <form id="form_delete<?php echo Pages::$table['line'][0] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo Pages::$table['line'][0] ?>')" enctype="multipart/form-data">
                                            <input hidden name="delete" value="<?php echo Pages::$table['line'][0] ?>">
                                            <div>
                                                <button type="submit" name="delete_but" class="btn btn-primary btn-sm" data-bs-placement="left" data-bs-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="bi-trash"> </span></button>
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