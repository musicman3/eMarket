<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Settings,
};
use \eMarket\Admin\Templates;
?>

<div id="settings_templates">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <span class="settings_back"><button type="button" onClick='location.href = "<?php echo Settings::parentPartitionGenerator() ?>"' class="btn btn-primary btn-sm"><span class="bi-reply"></span></button></span><span class="settings_name"><?php echo Settings::titlePageGenerator() ?></span>
            </h5>
        </div>
        <div class="modal-body">

            <div class="row">
		<div class="col-2">
		    <div class="input-group has-error">
			<span class="input-group-text"><span class="bi-grid-fill"></span></span>
			<form method="get" name="select_template" action="index.php">
			    <input hidden name="route" value="settings/templates">
			    <select name="name_templates" id="name_templates" class="form-select"  onchange="selectTemplate()">
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
		    <div class="input-group has-error">
			<span class="input-group-text"><span class="bi-file-text"></span></span>
			<form method="get" name="select_page">
			    <input hidden name="route" value="settings/templates">
			    <input type="hidden" name="name_templates" value="<?php echo Templates::$select_template ?>" />
			    <select name="layout_pages_templates" id="layout_pages_templates" class="form-select" onchange="selectPage()">
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
                <ul id="sortable1" class="connectedSortable block-ul" style="width:66.3%">
                    <li class="sortno border bg-primary text-center text-white">header &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_header as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable2" class="connectedSortable block-ul" style="width:33.3%">
                    <li class="sortno border bg-primary text-center text-white"><span class="bi-arrow-left-right"></span> <span class="bi-trash"></span></li>
                    <?php foreach (Templates::$layout_header_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="d-flex justify-content-center">
                <ul id="sortable3" class="connectedSortable2 block-ul" style="width:66.3%">
                    <li class="sortno border bg-primary text-center text-white">content &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_content as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable4" class="connectedSortable2 block-ul" style="width:33.3%">
                    <li class="sortno border bg-primary text-center text-white"><span class="bi-arrow-left-right"></span> <span class="bi-trash"></span></li>
                    <?php foreach (Templates::$layout_content_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="d-flex justify-content-center">
                <ul id="sortable5" class="connectedSortable3 block-l" style="width:33.2%;">
                    <li class="sortno border-l bg-primary text-center text-white">boxes-left &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_boxes_left as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable6" class="connectedSortable3 block-m block-r" style="width:33.2%;">
                    <li class="sortno border-r bg-primary text-center text-white">boxes-right &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_boxes_right as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable7" class="connectedSortable3 block-ul" style="width:33.2%">
                    <li class="sortno border bg-primary text-center text-white"><span class="bi-arrow-left-right"></span> <span class="bi-trash"></span></li>
                    <?php foreach (Templates::$layout_boxes_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="d-flex justify-content-center">
                <ul id="sortable8" class="connectedSortable4 block-ul" style="width:66.3%">
                    <li class="sortno border bg-primary text-center text-white">footer &nbsp;<span class="bi-arrow-left-right"></span></li>
                    <?php foreach (Templates::$layout_footer as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                    <?php } ?>
                </ul>
                <ul id="sortable9" class="connectedSortable4 block-ul" style="width:33.3%">
                    <li class="sortno border bg-primary text-center text-white"><span class="bi-arrow-left-right"></span> <span class="bi-trash"></span></li>
                    <?php foreach (Templates::$layout_footer_basket as $path) { ?>
                        <li id="<?php echo basename($path, '.php') ?>" class="sortyes text-center"><?php echo basename($path, '.php') ?></li>
                        <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>