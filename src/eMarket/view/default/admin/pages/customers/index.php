<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    Pages,
    Valid,
    Settings
};
?>

<div id="customers">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h5 class="card-title col text-center"><?php echo Settings::titlePageGenerator() ?></h5>
        </div>
        <div class="card-body">

            <div class="col-xl-3 col-lg-4 col-md-6 col-12 px-0">
                <form>
                    <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                    <div class="input-group input-group-sm">
                        <input type="search" id="search" name="search" placeholder="<?php echo lang('search') ?>" class="form-control">
                        <button type="submit" class="btn btn-primary btn-sm bi-search"></button>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="align-middle">
                            <th colspan="4"><?php echo Pages::counterPage() ?></th>

                            <th>
                                <div class="gap-2 d-flex justify-content-end">

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                        <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                        <?php if (Pages::$start > 0) { ?>
                                            <button type="submit" class="btn btn-primary btn-sm bi-arrow-left-short" formmethod="get"></button>
                                        <?php } else { ?>
                                            <a type="submit" class="btn btn-primary btn-sm disabled bi-arrow-left-short"></a>
                                        <?php } ?>
                                    </form>

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="start" value="<?php echo Pages::$start ?>">
                                        <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                        <?php if (Pages::$finish != Pages::$count) { ?>
                                            <button type="submit" class="btn btn-primary btn-sm bi-arrow-right-short" formmethod="get"></button>
                                        <?php } else { ?>
                                            <a type="submit" class="btn btn-primary btn-sm disabled bi-arrow-right-short"></a>
                                        <?php } ?>
                                    </form>

                                </div>
                            </th>
                        </tr>
                        <?php if (Pages::$finish > 0) { ?>
                            <tr class="align-middle">
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
                            <tr class="<?php echo Settings::statusSwitchClass(Pages::$table['line'][18]) ?> align-middle">
                                <td><?php echo Pages::$table['line'][3] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line'][4] ?></td>
                                <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line'][6]) ?></td>
                                <td class="text-center"><?php echo Pages::$table['line'][11] ?></td>
                                <td>
                                    <div class="gap-2 d-flex justify-content-end">
                                        <form id="form_status<?php echo Pages::$table['line'][0] ?>" name="form_status" action="javascript:void(null);" enctype="multipart/form-data">
                                            <input hidden name="status" value="<?php echo Pages::$table['line'][0] ?>">
                                            <button type="button" name="status_but" class="btn btn-primary btn-sm bi-power" onclick="Confirmation.update('form_status<?php echo Pages::$table['line'][0] ?>', '<?php echo lang('confirm-status') ?>')"></button>
                                        </form>
                                        <form id="form_delete<?php echo Pages::$table['line'][0] ?>" name="form_delete" action="javascript:void(null);" enctype="multipart/form-data">
                                            <input hidden name="delete" value="<?php echo Pages::$table['line'][0] ?>">
                                            <button type="button" name="delete_but" class="btn btn-primary btn-sm bi-trash" onclick="Confirmation.del('<?php echo Pages::$table['line'][0] ?>')"></button>
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