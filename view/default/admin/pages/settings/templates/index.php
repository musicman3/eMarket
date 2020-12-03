<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div>
    <div id="settings_templates" class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="settings_back"><button type="button" onClick='location.href = "<?php echo \eMarket\Set::parentPartitionGenerator() ?>"' class="btn btn-primary btn-xs"><span class="back glyphicon glyphicon-share-alt"></span></button></span><span class="settings_name"><?php echo \eMarket\Set::titlePageGenerator() ?></span>
                </h3>
            </div>
            <div class="panel-body">

                <div class="form-inline">
                    <div class="input-group has-error">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th-large"></span></span>
                        <form method="get" name="select_template" action="index.php">
                            <input hidden name="route" value="settings/templates">
                            <select name="name_templates" id="name_templates" class="input-sm form-control"  onchange="selectTemplate(event)">
                                <option><?php echo \eMarket\Set::template() ?></option>
                                <?php
                                foreach ($name_template as $path) {
                                    if ($path != '.' && $path != '..' && $path != \eMarket\Set::template()) {
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

                    <div class="input-group has-error">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <form method="get" name="select_page">
                            <input hidden name="route" value="settings/templates">
                            <input type="hidden" name="name_templates" value="<?php echo $select_template ?>" />
                            <select name="layout_pages_templates" id="layout_pages_templates" class="input-sm form-control" onchange="selectPage(event)">
                                <option value="all"><?php echo lang('all_pages_template') ?></option>
                                <?php
                                if (!\eMarket\Valid::inGET('layout_pages_templates')) {
                                    $select_page = 'catalog';
                                }
                                foreach ($layout_pages as $path) {
                                    if ($path != '.' && $path != '..') {
                                        if ($path == $select_page) {
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

                <div class="clearfix"></br></div>
                <div class="center-block">
                    <ul id="sortable1" class="connectedSortable block-ul" style="width:66%">
                        <li class="sortno border bg-primary">header &nbsp;<span class="glyphicon glyphicon-resize-horizontal"></span></li>
                        <?php foreach ($layout_header as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable2" class="connectedSortable block-ul" style="width:33%">
                        <li class="sortno border bg-primary"><span class="glyphicon glyphicon-resize-horizontal"></span><span class="glyphicon glyphicon-trash"></span></li>
                        <?php foreach ($layout_header_basket as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable3" class="connectedSortable2 block-ul" style="width:66%">
                        <li class="sortno border bg-primary">content &nbsp;<span class="glyphicon glyphicon-resize-horizontal"></span></li>
                        <?php foreach ($layout_content as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable4" class="connectedSortable2 block-ul" style="width:33%">
                        <li class="sortno border bg-primary"><span class="glyphicon glyphicon-resize-horizontal"></span><span class="glyphicon glyphicon-trash"></span></li>
                        <?php foreach ($layout_content_basket as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable5" class="connectedSortable3 block-l" style="width:33%;">
                        <li class="sortno border-l bg-primary">boxes-left &nbsp;<span class="glyphicon glyphicon-resize-horizontal"></span></li>
                        <?php foreach ($layout_boxes_left as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable6" class="connectedSortable3 block-m block-r" style="width:33%;">
                        <li class="sortno border-r bg-primary">boxes-right &nbsp;<span class="glyphicon glyphicon-resize-horizontal"></span></li>
                        <?php foreach ($layout_boxes_right as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable7" class="connectedSortable3 block-ul" style="width:33%">
                        <li class="sortno border bg-primary"><span class="glyphicon glyphicon-resize-horizontal"></span><span class="glyphicon glyphicon-trash"></span></li>
                        <?php foreach ($layout_boxes_basket as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="center-block">
                    <ul id="sortable8" class="connectedSortable4 block-ul" style="width:66%">
                        <li class="sortno border bg-primary">footer &nbsp;<span class="glyphicon glyphicon-resize-horizontal"></span></li>
                        <?php foreach ($layout_footer as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                    </ul>
                    <ul id="sortable9" class="connectedSortable4 block-ul" style="width:33%">
                        <li class="sortno border bg-primary"><span class="glyphicon glyphicon-resize-horizontal"></span><span class="glyphicon glyphicon-trash"></span></li>
                        <?php foreach ($layout_footer_basket as $path) { ?>
                            <li id="<?php echo basename($path, '.php') ?>" class="sortyes"><?php echo basename($path, '.php') ?></li>
                            <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>