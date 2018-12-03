<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<div id="add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Сокращенное наименование указывается любыми символами" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_'. $SET->titleDir() .'_index') ?></h4>
            </div>
            <form id="form" name="form" action="index.php" onsubmit="$('.modal').modal('hide')" method="get" enctype="multipart/form-data">
                <div class="panel-body">
                    <input type="hidden" name="add" value="ok" />

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

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo $LANG_ALL[0] ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('name_full') ?>" type="text" name="<?php echo $SET->titleDir() . '_' . $LANG_ALL[0] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('name_little') ?>" type="text" name="unit<?php echo $LANG_ALL[0] ?>" id="unit<?php echo $LANG_ALL[0] ?>" />
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
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name_full') ?>" type="text" name="<?php echo $SET->titleDir() . '_' . $LANG_ALL[$xl] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name_little') ?>" type="text" name="unit<?php echo $LANG_ALL[$xl] ?>" id="unit<?php echo $LANG_ALL[$xl] ?>" />
                                        </div>
                                    </div>
                                </div>

                            <?php }
                        } ?>
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
<!-- КОНЕЦ Модальное окно "Добавить" -->