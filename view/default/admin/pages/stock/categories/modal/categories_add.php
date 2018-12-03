<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Добавить категорию" -->
<div id="addCategory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку категорий" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('menu_categories') ?></h4>
            </div>
            <form id="form_get" name="form_get" action="javascript:void(null);" onsubmit="call()" method="get" enctype="multipart/form-data">
                <div class="panel-body">
                        <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
                    <!-- Языковые панели -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#<?php echo $LANG_ALL[0] ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/langflags/<?php echo $LANG_ALL[0] ?>.png" alt="<?php echo $LANG_ALL[0] ?>" title="<?php echo $LANG_ALL[0] ?>" width="16" height="10" /> <?php echo lang('language_name', $LANG_ALL[0]) ?></a></li>

                        <?php
                        if (count($LANG_ALL) > 1) {
                            for ($xl = 1; $xl < count($LANG_ALL); $xl++) {
                                ?>

                                <li><a data-toggle="tab" href="#<?php echo $LANG_ALL[$xl] ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/langflags/<?php echo $LANG_ALL[$xl] ?>.png" alt="<?php echo $LANG_ALL[$xl] ?>" title="<?php echo $LANG_ALL[$xl] ?>" width="16" height="10" /> <?php echo lang('language_name', $LANG_ALL[$xl]) ?></a></li>

                                <?php
                            }
                        }
                        ?>

                    </ul>
		    <div class="tab-content">
                        <div id="<?php echo $LANG_ALL[0] ?>" class="tab-pane fade in active">
                        <div class="form-group">
			    <div class="input-group has-error">
				<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
				<input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="<?php echo $LANG_ALL[0] ?>" />
			    </div>
                        </div>
			</div>
                        <?php
                        if (count($LANG_ALL) > 1) {
                            for ($xl = 1; $xl < count($LANG_ALL); $xl++) {
                                ?>

                                <div id="<?php echo $LANG_ALL[$xl] ?>" class="tab-pane fade">
                                    <div class="form-group">
					<div class="input-group has-error">
					    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
					    <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="<?php echo $LANG_ALL[$xl] ?>" />
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
                            <input class="check-box" type="checkbox" name="view_cat" checked>
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
    function call() {
        var msg = $('#form_get').serialize();
        $.ajax({
            type: 'GET',
            url: '/controller/admin/pages/stock/categories/categories.php',
            data: msg,
            success: function (data) {
                $('#addCategory').modal('hide');
                document.location.reload(false);
            }
        });
    }
</script>
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->