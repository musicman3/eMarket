<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Pages,
    Valid,
    Settings
};
use eMarket\Core\Modules\Tabs\Reviews;

require_once('modal/index.php')
?>

<div id="ajax_data" class='hidden' data-jsondata='<?php echo Reviews::$json_data ?>'></div>

<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th colspan="4"><?php echo Pages::counterPage() ?></th>

                <th>
                    <div class="gap-2 d-flex justify-content-end">

                        <form>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                            <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                            <input hidden name="type" value="<?php echo Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo Valid::inGET('name') ?>">
                            <?php if (Pages::$start > 0) { ?>
                                <button type="submit" class="btn btn-primary btn-sm bi-arrow-left-short" formmethod="get"></button>
                            <?php } else { ?>
                                <a type="submit" class="btn btn-primary btn-sm disabled bi-arrow-left-short"></a>
                            <?php } ?>
                        </form>

                        <form>
                            <input hidden name="route" value="settings/modules/edit">
                            <input hidden name="start" value="<?php echo Pages::$start ?>">
                            <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                            <input hidden name="type" value="<?php echo Valid::inGET('type') ?>">
                            <input hidden name="name" value="<?php echo Valid::inGET('name') ?>">
                            <?php if (Pages::$finish != Pages::$count) { ?>
                                <button type="submit" class="btn btn-primary btn-sm bi-arrow-right-short" formmethod="get"></button>
                            <?php } else { ?>
                                <a type="submit" class="btn btn-primary btn-sm disabled bi-arrow-right-short"></a>
                            <?php } ?>
                        </form>

                    </div>
                </th>
            </tr>
            <?php if (Pages::$count > 0) { ?>
                <tr class="align-middle">
                    <th><?php echo lang('modules_tabs_reviews_admin_date_added') ?></th>
                    <th class="text-center"><?php echo lang('modules_tabs_reviews_admin_product') ?></th>
                    <th class="text-center"><?php echo lang('modules_tabs_reviews_admin_author') ?></th>
                    <th class="text-center"><?php echo lang('modules_tabs_reviews_admin_rating') ?></th>
                    <th></th>
                </tr>
            <?php } ?>
        </thead>
        <tbody>
            <?php
            for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) {
                ?>
                <tr>
                    <td><?php echo Settings::dateLocale(Pages::$table['line']['date_add']) ?></td>
                    <td class="text-center"><button type="button" class="btn btn-primary btn-sm bi-box-arrow-up-right" onClick="window.open('/?route=products&category_id=2&id=<?php echo Pages::$table['line']['product_id'] ?>')"></button></td>
                    <td class="text-center"><?php echo Pages::$table['line']['author'] ?></td>
                    <td class="text-center">
                        <?php
                        for ($count = 0; $count < 5; $count++) {
                            if ($count < Pages::$table['line']['stars']) {
                                ?>
                                <span class="text-warning bi-star-fill"></span>
                            <?php } else { ?>
                                <span class="text-warning bi-star"></span>
                                <?php
                            }
                        }
                        ?>
                    <td>
                        <div class="gap-2 d-flex justify-content-end">
                            <form id="form_publish<?php echo Pages::$table['line']['id'] ?>" name="form_publish" action="javascript:void(null);" enctype="multipart/form-data">
                                <input hidden name="publish" value="<?php echo Pages::$table['line']['id'] ?>">
                                <button type="button" name="publish_but" class="btn btn-success btn-sm bi-check2" onclick="Confirmation.update('form_publish<?php echo Pages::$table['line']['id'] ?>', '<?php echo lang('modules_tabs_reviews_admin_confirm_publish') ?>')"></button>
                            </form>
                            <button type="button" class="btn btn-primary btn-sm bi-pencil-square" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"></button>
                            <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
                                <input hidden name="delete" value="<?php echo Pages::$table['line']['id'] ?>">
                                <button type="button" name="delete_but" class="btn btn-primary btn-sm bi-trash" onclick="Confirmation.del('<?php echo Pages::$table['line']['id'] ?>')"></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>