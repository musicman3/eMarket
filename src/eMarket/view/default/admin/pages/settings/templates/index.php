<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Settings,
};
use eMarket\Admin\Templates;
?>

<div id="settings_templates">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title row justify-content-between">
                <div class="col-4 text-start">
                    <button type="button" onClick='location.href = "<?php echo Settings::parentPartitionGenerator() ?>"' class="btn btn-primary btn-sm bi-reply"> <?php echo lang('button_back') ?></button>
                </div>
                <div class="col-4 text-center">
                    <?php echo Settings::titlePageGenerator() ?>
                </div>
                <div class="col-4 text-end"></div>
            </h5>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-auto">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bi-grid-fill"></span>
                        <form method="get" class="was-validated" name="select_template" action="index.php">
                            <input hidden name="route" value="settings/templates">
                            <select name="name_templates" id="name_templates" class="form-select">
                                <option><?php echo Settings::template() ?></option>
                                <?php
                                foreach (Templates::$name_template as $path) {
                                    if ($path != '.' && $path != '..' && $path != Settings::template()) {
                                        if ($path == Templates::$select_template) {
                                            ?>
                                            <option selected><?php echo $path ?></option>
                                        <?php } else {
                                            ?>
                                            <option><?php echo $path ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bi-file-text"></span>
                        <form method="get" class="was-validated" name="select_page">
                            <input hidden name="route" value="settings/templates">
                            <input type="hidden" name="name_templates" value="<?php echo Templates::$select_template ?>" />
                            <select name="layout_pages_templates" id="layout_pages_templates" class="form-select">
                                <option value="all"><?php echo lang('all_pages_template') ?></option>
                                <?php
                                foreach (Templates::$layout_pages as $path) {
                                    if ($path != '.' && $path != '..') {
                                        if ($path == Templates::$select_page) {
                                            ?>
                                            <option value="<?php echo $path ?>" selected><?php echo $path ?></option>
                                        <?php } else {
                                            ?>
                                            <option><?php echo $path ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="clearfix"></br></div>
            <div class="d-flex justify-content-center">
                <ul id="sortable1" class="border rounded-top ps-0 list-unstyled" style="width:66.3%">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1">header &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_header as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable2" class="border rounded-top ps-0 list-unstyled" style="width:33.3%">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1 bi-arrow-left-right"> <span class="bi-trash"></span></li>
                    <?php foreach (Templates::$layout_header_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="d-flex justify-content-center">
                <ul id="sortable3" class="border rounded-top ps-0 list-unstyled" style="width:66.3%">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1">content &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_content as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable4" class="border rounded-top ps-0 list-unstyled" style="width:33.3%">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1 bi-arrow-left-right"> <span class="bi-trash"></span></li>
                    <?php foreach (Templates::$layout_content_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="d-flex justify-content-center">
                <ul id="sortable5" class="border rounded-top ps-0 list-unstyled" style="width:33.2%;">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1">boxes-left &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_boxes_left as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable6" class="border rounded-top ps-0 list-unstyled" style="width:33.2%;">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1">boxes-right &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_boxes_right as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable7" class="border rounded-top ps-0 list-unstyled" style="width:33.2%">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1 bi-arrow-left-right"> <span class="bi-trash"></span></li>
                    <?php foreach (Templates::$layout_boxes_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="d-flex justify-content-center">
                <ul id="sortable8" class="border rounded-top ps-0 list-unstyled" style="width:66.3%">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1">footer &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_footer as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable9" class="border rounded-top ps-0 list-unstyled" style="width:33.3%">
                    <li class="sortno rounded-top bg-primary text-center text-white py-1 mb-1 bi-arrow-left-right"> <span class="bi-trash"></span></li>
                    <?php foreach (Templates::$layout_footer_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center pb-1"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>