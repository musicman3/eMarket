<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
require(ROOT . '/controller/admin/pages/stock/categories/modal/categories_edit.php');
?>

<!-- Модальное окно "Редактировать категорию" -->
<div id="<?php echo 'addCategory' . $lines[$k][0] ?>" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку категорий" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('menu_categories') ?></h4>
            </div>
            <form id="form_get<?php echo $lines[$k][0] ?>" action="javascript:void(null);" onsubmit="call<?php echo $lines[$k][0] ?>()" method="get" enctype="multipart/form-data">
                <div class="panel-body">
                        <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
                        <input type="hidden" name="cat_edit" value="<?php echo $lines[$k][0] ?>" />
                    <!-- Языковые панели -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#<?php echo $lang_all[0] . $lines[$k][0] ?>"><img src="/view/<?php echo $TEMPLATE ?>/admin/images/langflags/<?php echo $lang_all[0] ?>.png" alt="<?php echo $lang_all[0] ?>" title="<?php echo $lang_all[0] ?>" width="16" height="10" /> <?php echo $general[strtolower($lang_all[0])]['language_name'] ?></a></li>

                        <?php
                        if (count($lang_all) > 1) {
                            for ($xl = 1; $xl < count($lang_all); $xl++) {
                                ?>

                                <li><a data-toggle="tab" href="#<?php echo $lang_all[$xl] . $lines[$k][0] ?>"><img src="/view/<?php echo $TEMPLATE ?>/admin/images/langflags/<?php echo $lang_all[$xl] ?>.png" alt="<?php echo $lang_all[$xl] ?>" title="<?php echo $lang_all[$xl] ?>" width="16" height="10" /> <?php echo $general[strtolower($lang_all[$xl])]['language_name'] ?></a></li>

                                <?php
                            }
                        }
                        ?>

                    </ul>
		    <div class="tab-content">
                        <div id="<?php echo $lang_all[0] . $lines[$k][0] ?>" class="tab-pane fade in active">
                        <div class="form-group">
			    <div class="input-group has-error">
				<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                <input class="input-sm form-control" type="text" name="name_edit<?php echo $lang_all[0] ?>" id="name_edit<?php echo $lang_all[0] ?>" value="<?php echo $name_category_edit[0] ?>" />
			    </div>
                        </div>
			</div>
                        <?php
                        if (count($lang_all) > 1) {
                            for ($xl = 1; $xl < count($lang_all); $xl++) {
                                ?>

                                <div id="<?php echo $lang_all[$xl] . $lines[$k][0] ?>" class="tab-pane fade">
                                    <div class="form-group">
					<div class="input-group has-error">
					    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
					    <input class="input-sm form-control" type="text" name="name_edit<?php echo $lang_all[$xl] ?>" id="name_edit<?php echo $lang_all[$xl] ?>" value="<?php echo $name_category_edit[$xl] ?>" />
					</div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
		    </div>
                        <div class="form-group">
                            <label for="image"><?php echo lang('images') ?>:</label><br>
                            <input type="file" name="image" id="image" /> <?php echo lang('max') ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                        </div>
                        <div class="form-group">
                            <label for="view_category"><?php echo lang('display') ?> </label>
                            <input class="check-box" type="checkbox" name="view_cat" <?php echo $status_category_edit ?>>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    function call<?php echo $lines[$k][0] ?>() {
        var msg = $('#form_get<?php echo $lines[$k][0] ?>').serialize();
        $.ajax({
            type: 'GET',
            url: '/controller/admin/pages/stock/categories/categories.php',
            data: msg,
            success: function (data) {
                $('#addCategory<?php echo $lines[$k][0] ?>').modal('hide');
                $('#ajax').html(data);
            }
        });
    }
</script>
<!-- КОНЕЦ Модальное окно "Редактировать категорию" -->