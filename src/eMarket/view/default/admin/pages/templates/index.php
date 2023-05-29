<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Settings,
};
use eMarket\Admin\Templates;

require_once('modal/name.php')
?>

<div id="settings_templates">
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col mb-3">
                    <form method="get" name="select_template" action="index.php">
                        <div class="input-group">
                            <span class="input-group-text bi-grid-fill"></span>
                            <input hidden name="route" value="templates">
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
                        </div>
                    </form>
                </div>

                <div class="col mb-3">
                    <div class="input-group">
                        <select class="form-select" id="config_list">
                            <?php
                            foreach (Templates::$tpl_cfg as $file) {
                                if ($file != '.' && $file != '..' && $file != '.gitkeep') {
                                    ?>
                                    <option><?php echo basename($file, '.tcg') ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <button class="btn btn-warning" id="save_config" type="button"><?php echo lang('templates_save') ?></button>
                        <button class="btn btn-danger" id="delete_config" type="button"><?php echo lang('templates_delete') ?></button>
                        <button class="btn btn-success" id="set_config" type="button"><?php echo lang('templates_set') ?></button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <form method="get" name="select_page">
                        <div class="input-group">
                            <span class="input-group-text bi-file-text" for="layout_pages_templates"></span>
                            <input hidden name="route" value="templates">
                            <input type="hidden" name="name_templates" value="<?php echo Templates::$select_template ?>" />
                            <select name="layout_pages_templates" id="layout_pages_templates" class="form-select">
                                <option value="all"><?php echo lang('templates_all_pages') ?></option>
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
                        </div>
                    </form>
                </div>

                <div class="col mb-3"></div>

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