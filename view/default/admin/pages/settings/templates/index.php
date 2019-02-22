<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div id="settings_templates" class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <div class="pull-left"><a class="btn btn-primary btn-xs" href="../"><span class="back glyphicon glyphicon-share-alt"></span></a> Шаблоны</div>
                <div class="clearfix"></div>
            </h3>
        </div>
        <div class="panel-body">

            <div class="pull-left form-group">
                <div class="input-group has-error">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th-large"></span></span>
                    <form method="get" name="select_template" action="index.php">
                        <select name="name_templates" id="name_templates" class="input-sm form-control"  onchange="selectTemplate(event)">
                            <option><?php echo $SET->template() ?></option>
                            <?php
                            foreach ($name_template as $path) {
                                if ($path != '.' && $path != '..' && $path != $SET->template()) {
                                    if ($path == $select_template) {

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

            <div class="pull-left form-group">
                <div class="input-group has-error">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                    <form method="get" name="select_page" action="index.php">
                        <input type="hidden" name="name_templates" value="<?php echo $select_template ?>" />
                        <select name="layout_pages_templates" id="layout_pages_templates" class="input-sm form-control" onchange="selectPage(event)">
                            <option>Все страницы</option>
                            <?php if ($select_page == 'catalog' OR ! $VALID->inGET('layout_pages_templates')) { ?>
                                <option selected>catalog</option>
                            <?php } else {

                                ?>
                                <option>catalog</option>
                                <?php
                            }
                            foreach ($layout_pages as $path) {
                                if ($path != '.' && $path != '..') {
                                    if ($path == $select_page) {

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

            <div class="clearfix"></div>
            <div class="center-block">
                <ul id="sortable1" class="connectedSortable block-ul" style="width:66%">
                    <li class="sortno border list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span>&nbsp;&nbsp;header</li>
                    <?php foreach ($layout_header as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable2" class="connectedSortable block-ul" style="width:33%">
                    <li class="sortno border list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span><span class="glyphicon glyphicon-trash"></span></li>
                    <?php foreach ($layout_header_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="center-block">
                <ul id="sortable3" class="connectedSortable2 block-ul" style="width:66%">
                    <li class="sortno border list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span>&nbsp;&nbsp;content</li>
                    <?php foreach ($layout_content as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable4" class="connectedSortable2 block-ul" style="width:33%">
                    <li class="sortno border list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span><span class="glyphicon glyphicon-trash"></span></li>
                    <?php foreach ($layout_content_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="center-block">
                <ul id="sortable5" class="connectedSortable3 block-l" style="width:33%;">
                    <li class="sortno border-l list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span>&nbsp;&nbsp;boxes-left</li>
                    <?php foreach ($layout_boxes_left as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable6" class="connectedSortable3 block-m block-r" style="width:33%;">
                    <li class="sortno border-r list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span>&nbsp;&nbsp;boxes-right</li>
                    <?php foreach ($layout_boxes_right as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable7" class="connectedSortable3 block-ul" style="width:33%">
                    <li class="sortno border list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span><span class="glyphicon glyphicon-trash"></span></li>
                    <?php foreach ($layout_boxes_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="center-block">
                <ul id="sortable8" class="connectedSortable4 block-ul" style="width:66%">
                    <li class="sortno border list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span>&nbsp;&nbsp;footer</li>
                    <?php foreach ($layout_footer as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable9" class="connectedSortable4 block-ul" style="width:33%">
                    <li class="sortno border list-group-item-success"><span class="glyphicon glyphicon-resize-horizontal"></span><span class="glyphicon glyphicon-trash"></span></li>
                    <?php foreach ($layout_footer_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>