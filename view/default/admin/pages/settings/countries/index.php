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
use \eMarket\Admin\Countries;
require_once('modal/index.php')
?>

<div id="settings_countries">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h3 class="panel-title">
                <span class="settings_back"><button type="button" onClick='location.href = "<?php echo Settings::parentPartitionGenerator() ?>"' class="btn btn-primary btn-xs"><span class="back glyphicon glyphicon-share-alt"></span></button></span><span class="settings_name"><?php echo Settings::titlePageGenerator() ?></span>
            </h3>
        </div>
        <div class="panel-body">
            <div id="ajax_data" class='hidden' data-jsondata='<?php echo Countries::$json_data ?>'></div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="5"><?php echo Pages::counterPage() ?></th>

                            <th>

                                <div class="flexbox">

                                    <div class="b-left"><a href="#index" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a></div>

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                        <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                        <div class="b-left">
                                            <?php if (Pages::$start > 0) { ?>
                                                <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button>
                                            <?php } else { ?>
                                                <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                            <?php } ?>
                                        </div>
                                    </form>

                                    <form>
                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                        <input hidden name="start" value="<?php echo Pages::$start ?>">
                                        <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                        <div>
                                            <?php if (Pages::$finish != Pages::$count) { ?>
                                                <button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button>
                                            <?php } else { ?>
                                                <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                            <?php } ?>
                                        </div>
                                    </form>

                                </div>

                            </th>
                        </tr>
                        <?php if (Pages::$count > 0) { ?>
                            <tr class="border">
                                <th class="sortleft"></th>
                                <th><?php echo lang('country') ?></th>
                                <th class="text-center"><?php echo lang('alpha_2') ?></th>
                                <th class="text-center"><?php echo lang('alpha_3') ?></th>
                                <th class="text-center"><?php echo lang('country_flag') ?></th>
                                <th></th>
                            </tr>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                            <tr>
                                <td class="sortleft">
                                    <form>
                                        <input hidden name="route" value="settings/countries/regions">
                                        <input hidden name="country_id" value="<?php echo Pages::$table['line']['id'] ?>">
                                        <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></button>
                                    </form>
                                </td>
                                <td><?php echo Pages::$table['line']['name'] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line']['alpha_2'] ?></td>
                                <td class="text-center"><?php echo Pages::$table['line']['alpha_3'] ?></td>
                                <td class="text-center"><img src='/view/<?php echo Settings::template() ?>/admin/images/worldflags/<?php echo strtolower(Pages::$table['line']['alpha_2']) ?>.png'></td>
                                <td>
                                    <div class="flexbox">
                                        <div class="b-left">
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"><span class="glyphicon glyphicon-edit"></span></button>
                                        </div>
                                        <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
                                            <input hidden name="delete" value="<?php echo Pages::$table['line']['id'] ?>">
                                            <div>
                                                <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button>
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