<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    Pages,
    Lang,
    Settings
};
use eMarket\Admin\Contacts;
?>

<div id="contacts">
    <div class="card">

        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
        </div>

        <div id="ajax_data" class='hidden' data-lang='<?php echo json_encode(lang()) ?>'></div>

        <form id="form_add" class="was-validated" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
            <div class="card-body">

                <div class="tab-content pt-2">

                    <div id="panel_add_1" class="tab-pane fade show in active">

                        <input type="hidden" id="add" name="add" value="ok" />

                        <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

                        <div class="tab-content pt-2">

                            <?php for ($x = 0; $x < Lang::$count; $x++) { ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade <?php echo Pages::activeTab($x) ?>">
                                    <div class="mb-3">
                                        <div><small class="form-text text-muted"><?php echo lang('contacts_description') ?></small></div>
                                        <textarea rows="3" class="input-sm form-control wysiwyg" name="description_contacts_<?php echo $x ?>" id="description_contacts_<?php echo $x ?>" /><?php echo Contacts::$description[lang('#lang_all')[$x]] ?></textarea>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end"><button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button></div>

            </div>
        </form>
    </div>
</div>
