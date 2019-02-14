<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div id="settings_templates" class="container-fluid">
    <div class="row-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><a class="btn btn-primary btn-xs" href="../"><span class="back glyphicon glyphicon-share-alt"></span></a> Шаблоны</div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">
                <div class="pull-left input-group has-error">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                    <select name="layout_pages_templates" id="layout_pages_templates" class="input-sm form-control">
                        <option>Все страницы</option>
                        <option>catalog</option>
                        <option>listing</option>
                        <option>products</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="center-block">
                    <ul id="sortable1" class="connectedSortable block-ul" style="width:66%">
                        <li class="sortno border list-group-item-success">header</li>
                        <?php foreach ($layout_header as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable2" class="connectedSortable block-ul" style="width:33%">
                        <li class="sortno border list-group-item-success">Корзина header</li>
                        <?php foreach ($layout_header_glass as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable3" class="connectedSortable2 block-ul" style="width:66%">
                        <li class="sortno border list-group-item-success">content</li>
                        <?php foreach ($layout_content as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable4" class="connectedSortable2 block-ul" style="width:33%">
                        <li class="sortno border list-group-item-success">Корзина content</li>
                        <?php foreach ($layout_content_glass as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable5" class="connectedSortable3 block-l" style="width:33%;">
                        <li class="sortno border-l list-group-item-info">boxes-left</li>
                        <?php foreach ($layout_boxes_left as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable6" class="connectedSortable3 block-m block-r" style="width:33%;">
                        <li class="sortno border-r list-group-item-info">boxes-right</li>
                        <?php foreach ($layout_boxes_right as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable7" class="connectedSortable3 block-ul" style="width:33%">
                        <li class="sortno border list-group-item-info">Корзина boxes</li>
                        <?php foreach ($layout_boxes_glass as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable8" class="connectedSortable4 block-ul" style="width:66%">
                        <li class="sortno border list-group-item-success">footer</li>
                        <?php foreach ($layout_footer as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable9" class="connectedSortable4 block-ul" style="width:33%">
                        <li class="sortno border list-group-item-success">Корзина footer</li>
                        <?php foreach ($layout_footer_glass as $path) { ?>
                            <li class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
            </div>
        </div>
    </div>
</div>